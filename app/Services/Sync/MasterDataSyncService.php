<?php

namespace App\Services\Sync;

use App\Jobs\SendEduSyncBatchJob;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

class MasterDataSyncService
{
    public function __construct(
        private readonly MasterDataSyncPayloadFactory $payloadFactory,
    ) {
    }

    /**
     * @param  list<string>  $entities
     * @return array{batch_id:string, queued:int, updated:int, skipped:int}
     */
    public function enqueue(array $entities): array
    {
        if (! $this->schemaReady()) {
            return [
                'batch_id' => (string) Str::uuid(),
                'queued' => 0,
                'updated' => 0,
                'skipped' => 1,
            ];
        }

        $entities = $this->normalizeEntities($entities);
        $batchId = (string) Str::uuid();
        $queued = 0;
        $updated = 0;
        $skipped = 0;

        DB::transaction(function () use ($entities, $batchId, &$queued, &$updated, &$skipped): void {
            DB::table('sync_batches')->insert([
                'batch_id' => $batchId,
                'target_system' => 'edu',
                'status' => 'pending',
                'total_items' => 0,
                'success_items' => 0,
                'failed_items' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($entities as $entity) {
                $modelClass = $this->payloadFactory->modelClassFor($entity);
                /** @var Builder $query */
                $query = $modelClass::query();
                $this->eagerLoadIfNeeded($entity, $query);

                /** @var Model $record */
                foreach ($query->get() as $record) {
                    $payload = $this->payloadFactory->payloadFor($entity, $record);
                    $operation = $this->payloadFactory->operationFor($entity, $record);

                    if ($this->persistOutboxItem($batchId, $entity, $record, $payload, $operation)) {
                        $updated++;
                        continue;
                    }

                    $queued++;
                }
            }

            if ($queued === 0 && $updated === 0) {
                $skipped = 1;
            }

            DB::table('sync_batches')
                ->where('batch_id', $batchId)
                ->update([
                    'total_items' => $queued + $updated,
                    'status' => ($queued + $updated) > 0 ? 'pending' : 'empty',
                    'updated_at' => now(),
                ]);
        });

        return [
            'batch_id' => $batchId,
            'queued' => $queued,
            'updated' => $updated,
            'skipped' => $skipped,
        ];
    }

    public function enqueueModel(string $entity, Model $record, ?string $operation = null): ?string
    {
        if (! $this->schemaReady()) {
            return null;
        }

        $this->normalizeEntities([$entity]);

        $batchId = (string) Str::uuid();
        DB::transaction(function () use ($batchId, $entity, $record, $operation): void {
            DB::table('sync_batches')->insert([
                'batch_id' => $batchId,
                'target_system' => 'edu',
                'status' => 'pending',
                'total_items' => 1,
                'success_items' => 0,
                'failed_items' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $payload = $this->payloadFactory->payloadFor($entity, $record);
            $resolvedOperation = $operation ?? $this->payloadFactory->operationFor($entity, $record);
            $wasUpdated = $this->persistOutboxItem($batchId, $entity, $record, $payload, $resolvedOperation);

            if (! $wasUpdated) {
                DB::table('sync_batches')
                    ->where('batch_id', $batchId)
                    ->update(['updated_at' => now()]);
            }
        });

        return $batchId;
    }

    /**
     * @return array{batch_id:string,status:string,total:int,success:int,failed:int,results:array<int, array<string,mixed>>}
     */
    public function sendPending(int $limit = 100): array
    {
        $batchId = $this->nextDispatchableBatchIds(1)->first();

        if (! $batchId) {
            return [
                'batch_id' => (string) Str::uuid(),
                'status' => 'empty',
                'total' => 0,
                'success' => 0,
                'failed' => 0,
                'remaining' => 0,
                'results' => [],
            ];
        }

        return $this->sendBatch($batchId, $limit);
    }

    /**
     * @return array{queued_batches:int,queued_items:int,batch_ids:list<string>}
     */
    public function dispatchPendingBatches(int $itemLimit = 100, int $batchLimit = 1): array
    {
        $endpoint = rtrim((string) config('services.edu_sync.url'), '/');
        $apiKey = (string) config('services.edu_sync.api_key');
        $sharedSecret = (string) config('services.edu_sync.shared_secret');

        if ($endpoint === '' || $apiKey === '' || $sharedSecret === '') {
            throw new RuntimeException('Konfigurasi sinkronisasi EDUSYNC OS belum lengkap.');
        }

        $batchIds = $this->nextDispatchableBatchIds($batchLimit);

        if ($batchIds->isEmpty()) {
            return [
                'queued_batches' => 0,
                'queued_items' => 0,
                'batch_ids' => [],
            ];
        }

        $queuedItems = 0;

        foreach ($batchIds as $batchId) {
            $this->markBatchQueued($batchId);
            $queuedItems += $this->countDispatchableItemsForBatch($batchId);
            SendEduSyncBatchJob::dispatch($batchId, $itemLimit);
        }

        return [
            'queued_batches' => $batchIds->count(),
            'queued_items' => $queuedItems,
            'batch_ids' => $batchIds->values()->all(),
        ];
    }

    /**
     * @return array{batch_id:string,status:string,total:int,success:int,failed:int,remaining:int,results:array<int, array<string,mixed>>}
     */
    public function sendBatch(string $batchId, int $limit = 100): array
    {
        $endpoint = rtrim((string) config('services.edu_sync.url'), '/');
        $apiKey = (string) config('services.edu_sync.api_key');
        $sharedSecret = (string) config('services.edu_sync.shared_secret');
        $sourceSystem = (string) config('services.edu_sync.source_system', 'internal');

        if ($endpoint === '' || $apiKey === '' || $sharedSecret === '') {
            throw new RuntimeException('Konfigurasi sinkronisasi EDUSYNC OS belum lengkap.');
        }

        $items = DB::table('sync_outbox')
            ->where('batch_id', $batchId)
            ->whereIn('status', ['pending', 'retry'])
            ->where(function ($query): void {
                $query->whereNull('available_at')
                    ->orWhere('available_at', '<=', now());
            })
            ->orderBy('id')
            ->limit($limit)
            ->get();

        if ($items->isEmpty()) {
            $summary = $this->refreshBatchSummary($batchId);

            return [
                'batch_id' => $batchId,
                'status' => $summary['status'],
                'total' => $summary['total'],
                'success' => $summary['success'],
                'failed' => $summary['failed'],
                'remaining' => $summary['remaining'],
                'results' => [],
            ];
        }

        $payload = [
            'batch_id' => $batchId,
            'sent_at' => now()->toISOString(),
            'source_system' => $sourceSystem,
            'items' => $items->map(fn ($item) => [
                'entity' => $item->entity,
                'operation' => $item->operation,
                'source_id' => $item->record_id,
                'source_updated_at' => $item->source_updated_at
                    ? Carbon::parse($item->source_updated_at)->toISOString()
                    : now()->toISOString(),
                'payload' => json_decode((string) $item->payload, true, 512, JSON_THROW_ON_ERROR),
            ])->values()->all(),
        ];

        $timestamp = now()->toISOString();
        $rawPayload = json_encode(
            $payload,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );
        $signature = hash_hmac('sha256', "{$timestamp}.{$rawPayload}", $sharedSecret);

        DB::table('sync_batches')
            ->where('batch_id', $batchId)
            ->update([
                'status' => 'sending',
                'sent_at' => now(),
                'updated_at' => now(),
            ]);

        $response = Http::timeout(30)
            ->acceptJson()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-Sync-Key' => $apiKey,
                'X-Sync-Timestamp' => $timestamp,
                'X-Sync-Signature' => $signature,
            ])
            ->withBody($rawPayload, 'application/json')
            ->post("{$endpoint}/sync/master-data");

        if ($response->failed()) {
            $message = $response->body() ?: 'Request sinkronisasi ke EDUSYNC OS gagal.';
            $this->markOutboxFailure($items->pluck('id')->all(), $message);
            $summary = $this->refreshBatchSummary($batchId, $message);

            throw new RuntimeException($message);
        }

        $responseBody = $response->json();
        $results = collect($responseBody['results'] ?? []);

        $success = 0;
        $failed = 0;

        foreach ($items as $item) {
            $result = $results->first(function (array $result) use ($item): bool {
                return ($result['entity'] ?? null) === $item->entity
                    && (string) ($result['source_id'] ?? '') === (string) $item->record_id;
            });

            if (($result['status'] ?? null) === 'success') {
                DB::table('sync_outbox')
                    ->where('id', $item->id)
                    ->update([
                        'status' => 'synced',
                        'processed_at' => now(),
                        'last_error' => null,
                        'updated_at' => now(),
                    ]);
                $success++;
                continue;
            }

            $failed++;
            DB::table('sync_outbox')
                ->where('id', $item->id)
                ->update([
                    'status' => 'retry',
                    'attempt_count' => DB::raw('attempt_count + 1'),
                    'available_at' => now()->addMinutes(5),
                    'last_error' => $result['error_message'] ?? 'Sinkronisasi item gagal.',
                    'updated_at' => now(),
                ]);
        }

        $summary = $this->refreshBatchSummary($batchId);

        return [
            'batch_id' => $batchId,
            'status' => $summary['status'],
            'total' => $summary['total'],
            'success' => $summary['success'],
            'failed' => $summary['failed'],
            'remaining' => $summary['remaining'],
            'results' => $results->values()->all(),
        ];
    }

    /**
     * @return array{status:string,url:string,http_status:int|null,message:string,response:array<string,mixed>|null}
     */
    public function testConnection(): array
    {
        $endpoint = rtrim((string) config('services.edu_sync.url'), '/');

        if ($endpoint === '') {
            throw new RuntimeException('Konfigurasi EDU_SYNC_URL untuk EDUSYNC OS belum diisi.');
        }

        $healthUrl = "{$endpoint}/health";

        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->get($healthUrl);
        } catch (\Throwable $exception) {
            return [
                'status' => 'failed',
                'url' => $healthUrl,
                'http_status' => null,
                'message' => $exception->getMessage(),
                'response' => null,
            ];
        }

        if ($response->failed()) {
            return [
                'status' => 'failed',
                'url' => $healthUrl,
                'http_status' => $response->status(),
                'message' => 'Endpoint health EDUSYNC OS tidak merespons sukses.',
                'response' => $response->json(),
            ];
        }

        return [
            'status' => 'success',
            'url' => $healthUrl,
            'http_status' => $response->status(),
            'message' => 'Koneksi ke server EDUSYNC OS berhasil.',
            'response' => $response->json(),
        ];
    }

    /**
     * @param  list<string>  $entities
     * @return list<string>
     */
    private function normalizeEntities(array $entities): array
    {
        $supported = $this->payloadFactory->supportedEntities();

        if ($entities === []) {
            return $supported;
        }

        return collect($entities)
            ->map(fn ($entity) => trim((string) $entity))
            ->filter()
            ->map(function (string $entity) use ($supported): string {
                if (! in_array($entity, $supported, true)) {
                    throw new RuntimeException("Entity {$entity} tidak didukung untuk sinkronisasi.");
                }

                return $entity;
            })
            ->values()
            ->all();
    }

    private function eagerLoadIfNeeded(string $entity, Builder $query): void
    {
        if ($entity === 'classroom') {
            $query->with(['academicYear', 'major']);
            return;
        }

        if ($entity === 'student_class_membership') {
            $query->with(['studentProfile', 'classroom', 'academicYear', 'semester']);
            return;
        }

        if ($entity === 'teaching_assignment') {
            $query->with(['teacherProfile', 'subject', 'classroom', 'academicYear', 'semester']);
        }
    }

    /**
     * @param  list<int>  $ids
     */
    private function markOutboxFailure(array $ids, string $message): void
    {
        DB::table('sync_outbox')
            ->whereIn('id', $ids)
            ->update([
                'status' => 'retry',
                'attempt_count' => DB::raw('attempt_count + 1'),
                'available_at' => now()->addMinutes(5),
                'last_error' => $message,
                'updated_at' => now(),
            ]);
    }

    private function updateBatchStatus(
        string $batchId,
        string $status,
        int $success,
        int $failed,
        ?string $lastError,
    ): void {
        DB::table('sync_batches')
            ->where('batch_id', $batchId)
            ->update([
                'status' => $status,
                'success_items' => $success,
                'failed_items' => $failed,
                'finished_at' => now(),
                'last_error' => $lastError,
                'updated_at' => now(),
            ]);
    }

    public function hasDispatchableItems(string $batchId): bool
    {
        return $this->countDispatchableItemsForBatch($batchId) > 0;
    }

    public function releaseRetryItems(?string $entity = null): int
    {
        $query = DB::table('sync_outbox')
            ->where('status', 'retry');

        if ($entity) {
            $query->where('entity', $entity);
        }

        return $query->update([
            'available_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function schemaReady(): bool
    {
        return Schema::hasTable('sync_batches') && Schema::hasTable('sync_outbox');
    }

    private function persistOutboxItem(
        string $batchId,
        string $entity,
        Model $record,
        array $payload,
        string $operation,
    ): bool {
        $jsonPayload = json_encode(
            $payload,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );
        $existing = DB::table('sync_outbox')
            ->where('entity', $entity)
            ->where('record_id', (string) $record->getKey())
            ->whereIn('status', ['pending', 'retry'])
            ->orderByDesc('id')
            ->first();

        if ($existing) {
            $previousBatchId = $existing->batch_id;
            DB::table('sync_outbox')
                ->where('id', $existing->id)
                ->update([
                    'batch_id' => $batchId,
                    'operation' => $operation,
                    'payload' => $jsonPayload,
                    'payload_hash' => hash('sha256', $jsonPayload),
                    'source_updated_at' => $record->updated_at ?? now(),
                    'available_at' => now(),
                    'attempt_count' => 0,
                    'last_error' => null,
                    'updated_at' => now(),
                ]);

            if ($previousBatchId !== $batchId) {
                $this->refreshBatchSummary($previousBatchId);
            }

            $this->refreshBatchSummary($batchId);

            return true;
        }

        DB::table('sync_outbox')->insert([
            'batch_id' => $batchId,
            'entity' => $entity,
            'record_id' => (string) $record->getKey(),
            'operation' => $operation,
            'payload' => $jsonPayload,
            'payload_hash' => hash('sha256', $jsonPayload),
            'status' => 'pending',
            'attempt_count' => 0,
            'available_at' => now(),
            'source_updated_at' => $record->updated_at ?? now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->refreshBatchSummary($batchId);

        return false;
    }

    /**
     * @return \Illuminate\Support\Collection<int, string>
     */
    private function nextDispatchableBatchIds(int $limit)
    {
        return DB::table('sync_outbox')
            ->join('sync_batches', 'sync_batches.batch_id', '=', 'sync_outbox.batch_id')
            ->select('sync_outbox.batch_id', 'sync_batches.created_at', DB::raw('MIN(sync_outbox.id) as first_item_id'))
            ->whereIn('sync_outbox.status', ['pending', 'retry'])
            ->where(function ($query): void {
                $query->whereNull('sync_outbox.available_at')
                    ->orWhere('sync_outbox.available_at', '<=', now());
            })
            ->groupBy('sync_outbox.batch_id', 'sync_batches.created_at')
            ->orderByDesc('sync_batches.created_at')
            ->orderBy('first_item_id')
            ->limit($limit)
            ->pluck('sync_outbox.batch_id');
    }

    private function countDispatchableItemsForBatch(string $batchId): int
    {
        return DB::table('sync_outbox')
            ->where('batch_id', $batchId)
            ->whereIn('status', ['pending', 'retry'])
            ->where(function ($query): void {
                $query->whereNull('available_at')
                    ->orWhere('available_at', '<=', now());
            })
            ->count();
    }

    private function markBatchQueued(string $batchId): void
    {
        DB::table('sync_batches')
            ->where('batch_id', $batchId)
            ->update([
                'status' => 'queued',
                'last_error' => null,
                'finished_at' => null,
                'updated_at' => now(),
            ]);
    }

    /**
     * @return array{status:string,total:int,success:int,failed:int,remaining:int}
     */
    private function refreshBatchSummary(string $batchId, ?string $lastError = null): array
    {
        $summary = DB::table('sync_outbox')
            ->selectRaw(
                "COUNT(*) as total,
                SUM(CASE WHEN status = 'synced' THEN 1 ELSE 0 END) as success_count,
                SUM(CASE WHEN status = 'retry' THEN 1 ELSE 0 END) as failed_count,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count"
            )
            ->where('batch_id', $batchId)
            ->first();

        $total = (int) ($summary->total ?? 0);
        $success = (int) ($summary->success_count ?? 0);
        $failed = (int) ($summary->failed_count ?? 0);
        $pending = (int) ($summary->pending_count ?? 0);
        $remaining = $this->countDispatchableItemsForBatch($batchId);

        $status = match (true) {
            $total === 0 => 'empty',
            $pending > 0 || $remaining > 0 => 'queued',
            $failed > 0 && $success > 0 => 'partial_success',
            $failed > 0 => 'failed',
            default => 'success',
        };

        DB::table('sync_batches')
            ->where('batch_id', $batchId)
            ->update([
                'status' => $status,
                'total_items' => $total,
                'success_items' => $success,
                'failed_items' => $failed,
                'finished_at' => in_array($status, ['success', 'failed', 'partial_success', 'empty'], true) ? now() : null,
                'last_error' => $lastError,
                'updated_at' => now(),
            ]);

        return [
            'status' => $status,
            'total' => $total,
            'success' => $success,
            'failed' => $failed,
            'remaining' => $remaining,
        ];
    }
}
