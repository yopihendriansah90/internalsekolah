<?php

namespace App\Filament\Pages;

use App\Services\Sync\MasterDataSyncService;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EduSyncDashboard extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'Sinkronisasi EDUSYNC OS';

    protected static ?string $title = 'Sinkronisasi EDUSYNC OS';

    protected static string|\UnitEnum|null $navigationGroup = 'Integrasi Sistem';

    protected static ?int $navigationSort = 50;

    protected static ?string $slug = 'sinkronisasi/edu';

    protected string $view = 'filament.pages.edu-sync-dashboard';

    protected function getHeaderActions(): array
    {
        $entityOptions = $this->getEntityOptions();

        return [
            Action::make('testConnection')
                ->label('Tes Koneksi EDUSYNC OS')
                ->icon('heroicon-o-signal')
                ->color('info')
                ->action(function (MasterDataSyncService $syncService): void {
                    try {
                        $result = $syncService->testConnection();
                        $httpStatus = $result['http_status'] ?? '-';
                        $body = $result['status'] === 'success'
                            ? "Server EDUSYNC OS berhasil dihubungi.\nAlamat server: {$result['url']}\nStatus respon: HTTP {$httpStatus}."
                            : "Sistem belum bisa terhubung ke server EDUSYNC OS.\nAlamat yang diperiksa: {$result['url']}\nStatus respon: HTTP {$httpStatus}.\nKeterangan: {$result['message']}";

                        $notification = Notification::make()
                            ->title($result['status'] === 'success' ? 'Koneksi EDUSYNC OS berhasil.' : 'Koneksi EDUSYNC OS gagal.')
                            ->body($body);

                        if ($result['status'] === 'success') {
                            $notification->success();
                        } else {
                            $notification->danger();
                        }

                        $notification->send();
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Sinkronisasi belum bisa dijalankan.')
                            ->body("Pengaturan koneksi ke server EDUSYNC OS masih belum lengkap.\nKeterangan: {$exception->getMessage()}")
                            ->danger()
                            ->send();
                    }
                }),
            Action::make('enqueueMasterData')
                ->label('Antrekan Master Data')
                ->icon('heroicon-o-inbox-stack')
                ->color('gray')
                ->form([
                    CheckboxList::make('entities')
                        ->label('Data yang ingin dimasukkan ke antrean sinkronisasi')
                        ->options($entityOptions)
                        ->default(array_keys($entityOptions))
                        ->columns(2)
                        ->required(),
                ])
                ->action(function (array $data, MasterDataSyncService $syncService): void {
                    $entities = $data['entities'] ?? [];

                    if (! is_array($entities) || $entities === []) {
                        throw ValidationException::withMessages([
                            'data.entities' => 'Pilih minimal satu jenis data yang ingin disinkronkan.',
                        ]);
                    }

                    $invalidEntities = array_diff($entities, array_keys($this->getEntityOptions()));

                    if ($invalidEntities !== []) {
                        throw ValidationException::withMessages([
                            'data.entities' => 'Ada pilihan data yang tidak dikenali. Tutup form ini lalu coba lagi.',
                        ]);
                    }

                    $result = $syncService->enqueue($entities);
                    $totalPrepared = $result['queued'] + $result['updated'];

                    Notification::make()
                        ->title('Data sinkronisasi berhasil disiapkan.')
                        ->body(
                            $totalPrepared > 0
                                ? "Sebanyak {$totalPrepared} data berhasil dimasukkan ke antrean sinkronisasi.\nData baru: {$result['queued']}\nData yang diperbarui: {$result['updated']}\nID batch: {$result['batch_id']}"
                                : "Belum ada data baru yang perlu dimasukkan ke antrean sinkronisasi."
                        )
                        ->success()
                        ->send();
                }),
            Action::make('sendPending')
                ->label('Kirim ke EDUSYNC OS')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->form([
                    TextInput::make('limit')
                        ->label('Maksimum item per kirim')
                        ->numeric()
                        ->default(100)
                        ->required(),
                    TextInput::make('batch_limit')
                        ->label('Maksimum batch yang dimasukkan ke queue')
                        ->numeric()
                        ->default(1)
                        ->required(),
                ])
                ->action(function (array $data, MasterDataSyncService $syncService): void {
                    try {
                        $result = $syncService->dispatchPendingBatches(
                            (int) ($data['limit'] ?? 100),
                            (int) ($data['batch_limit'] ?? 1),
                        );
                    } catch (Throwable $exception) {
                        Notification::make()
                            ->title('Pengiriman ke EDUSYNC OS belum berhasil.')
                            ->body("Sistem belum bisa mengirim batch sinkronisasi ke server EDUSYNC OS.\nKeterangan: {$exception->getMessage()}")
                            ->danger()
                            ->send();

                        return;
                    }

                    $notification = Notification::make()
                        ->title($result['queued_batches'] > 0
                            ? 'Batch sinkronisasi berhasil dimasukkan ke queue.'
                            : 'Belum ada data yang perlu dikirim.')
                        ->body($result['queued_batches'] > 0
                            ? "Sebanyak {$result['queued_batches']} batch dimasukkan ke queue.\nItem siap diproses: {$result['queued_items']}\nQueue worker akan mengirim data ke server EDUSYNC OS secara bertahap."
                            : 'Antrean sinkronisasi saat ini kosong atau masih menunggu jadwal retry.');

                    if ($result['queued_batches'] > 0) {
                        $notification->success();
                    } else {
                        $notification->warning();
                    }

                    $notification->send();
                }),
            Action::make('processRetries')
                ->label('Proses Retry Sekarang')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->form([
                    Select::make('entity')
                        ->label('Fokuskan ke jenis data tertentu')
                        ->options(['' => 'Semua data retry'] + $entityOptions)
                        ->default(''),
                    TextInput::make('limit')
                        ->label('Maksimum item per kirim')
                        ->numeric()
                        ->default(100)
                        ->required(),
                    TextInput::make('batch_limit')
                        ->label('Maksimum batch yang dimasukkan ke queue')
                        ->numeric()
                        ->default(3)
                        ->required(),
                ])
                ->action(function (array $data, MasterDataSyncService $syncService): void {
                    $entity = blank($data['entity'] ?? null) ? null : (string) $data['entity'];
                    $released = $syncService->releaseRetryItems($entity);

                    if ($released === 0) {
                        Notification::make()
                            ->title('Belum ada item retry yang siap diproses.')
                            ->body('Semua item retry sudah bersih atau masih belum ada data yang perlu dicoba ulang.')
                            ->warning()
                            ->send();

                        return;
                    }

                    $result = $syncService->dispatchPendingBatches(
                        (int) ($data['limit'] ?? 100),
                        (int) ($data['batch_limit'] ?? 3),
                    );

                    Notification::make()
                        ->title('Retry berhasil dimasukkan ke queue.')
                        ->body("Item retry yang dibuka ulang: {$released}\nBatch yang dimasukkan ke queue: {$result['queued_batches']}\nItem siap diproses: {$result['queued_items']}")
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getSyncStats(): array
    {
        if (! $this->hasSyncTables()) {
            return [
                'pending' => 0,
                'retry' => 0,
                'synced' => 0,
                'failed_batches' => 0,
            ];
        }

        return [
            'pending' => DB::table('sync_outbox')->where('status', 'pending')->count(),
            'retry' => DB::table('sync_outbox')->where('status', 'retry')->count(),
            'synced' => DB::table('sync_outbox')->where('status', 'synced')->count(),
            'failed_batches' => DB::table('sync_batches')->where('status', 'failed')->count(),
        ];
    }

    public function getRecentBatches(): Collection
    {
        if (! $this->hasSyncTables()) {
            return collect();
        }

        $query = DB::table('sync_batches')
            ->orderByRaw("
                CASE status
                    WHEN 'sending' THEN 1
                    WHEN 'queued' THEN 2
                    WHEN 'pending' THEN 3
                    WHEN 'partial_success' THEN 4
                    WHEN 'failed' THEN 5
                    WHEN 'success' THEN 6
                    ELSE 7
                END
            ")
            ->orderByDesc('updated_at');

        $statusFilter = $this->getBatchStatusFilter();
        if ($statusFilter !== null) {
            $query->where('status', $statusFilter);
        }

        if ($entityFilter = $this->getEntityFilter()) {
            $query->whereExists(function ($subQuery) use ($entityFilter): void {
                $subQuery->selectRaw('1')
                    ->from('sync_outbox')
                    ->whereColumn('sync_outbox.batch_id', 'sync_batches.batch_id')
                    ->where('sync_outbox.entity', $entityFilter);
            });
        }

        return $query
            ->limit(10)
            ->get();
    }

    public function getRecentOutboxItems(): Collection
    {
        if (! $this->hasSyncTables()) {
            return collect();
        }

        $query = DB::table('sync_outbox')
            ->orderByDesc('updated_at');

        if ($entityFilter = $this->getEntityFilter()) {
            $query->where('entity', $entityFilter);
        }

        if ($statusFilter = $this->getOutboxStatusFilter()) {
            $query->where('status', $statusFilter);
        }

        return $query
            ->limit(10)
            ->get();
    }

    public function getFailedOutboxItems(): Collection
    {
        if (! $this->hasSyncTables()) {
            return collect();
        }

        $query = DB::table('sync_outbox')
            ->whereIn('status', ['retry'])
            ->orderByDesc('updated_at');

        if ($entityFilter = $this->getEntityFilter()) {
            $query->where('entity', $entityFilter);
        }

        return $query
            ->limit(10)
            ->get();
    }

    public function getActiveBatchSummary(): ?object
    {
        if (! $this->hasSyncTables()) {
            return null;
        }

        return DB::table('sync_batches')
            ->whereIn('status', ['pending', 'queued', 'sending', 'partial_success', 'failed'])
            ->orderByRaw("
                CASE status
                    WHEN 'sending' THEN 1
                    WHEN 'queued' THEN 2
                    WHEN 'pending' THEN 3
                    WHEN 'partial_success' THEN 4
                    WHEN 'failed' THEN 5
                    ELSE 6
                END
            ")
            ->orderByDesc('updated_at')
            ->first();
    }

    public function getBatchProgress(?object $batch): int
    {
        if (! $batch || (int) $batch->total_items === 0) {
            return 0;
        }

        $processed = (int) $batch->success_items + (int) $batch->failed_items;

        return (int) max(0, min(100, round(($processed / (int) $batch->total_items) * 100)));
    }

    public function hasSyncTables(): bool
    {
        return Schema::hasTable('sync_batches') && Schema::hasTable('sync_outbox');
    }

    public function getConfigWarnings(): array
    {
        $warnings = [];

        if (blank(config('services.edu_sync.url'))) {
            $warnings[] = 'EDU_SYNC_URL belum diisi.';
        }

        if (blank(config('services.edu_sync.api_key'))) {
            $warnings[] = 'EDU_SYNC_API_KEY belum diisi.';
        }

        if (blank(config('services.edu_sync.shared_secret'))) {
            $warnings[] = 'EDU_SYNC_SHARED_SECRET belum diisi.';
        }

        if (config('queue.default') === 'sync') {
            $warnings[] = 'QUEUE_CONNECTION masih menggunakan sync. Ganti ke database bila ingin pengiriman berjalan lewat queue worker.';
        }

        return $warnings;
    }

    /**
     * @return array<string, string>
     */
    public function getEntityOptions(): array
    {
        return [
            'academic_year' => 'Tahun ajaran',
            'semester' => 'Semester',
            'major' => 'Jurusan',
            'subject' => 'Mata pelajaran',
            'classroom' => 'Kelas',
            'teacher' => 'Guru',
            'student' => 'Siswa',
            'student_class_membership' => 'Penempatan siswa ke kelas',
            'teaching_assignment' => 'Assignment mengajar guru',
        ];
    }

    public function getEntityLabel(string $entity): string
    {
        return $this->getEntityOptions()[$entity] ?? $entity;
    }

    public function getBatchStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu dikirim',
            'queued' => 'Masuk antrean',
            'sending' => 'Sedang dikirim',
            'partial_success' => 'Sebagian berhasil',
            'failed' => 'Gagal',
            'success' => 'Berhasil',
            'empty' => 'Kosong',
            default => $status,
        };
    }

    public function getOutboxStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'retry' => 'Perlu dicoba lagi',
            'synced' => 'Berhasil',
            default => $status,
        };
    }

    public function getStatusBadgeClasses(string $status): string
    {
        return match ($status) {
            'success', 'synced' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'partial_success' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'failed', 'retry' => 'bg-rose-100 text-rose-700 ring-rose-200',
            'queued', 'sending' => 'bg-sky-100 text-sky-700 ring-sky-200',
            'pending' => 'bg-slate-100 text-slate-700 ring-slate-200',
            default => 'bg-gray-100 text-gray-700 ring-gray-200',
        };
    }

    public function getStatusIcon(string $status): string
    {
        return match ($status) {
            'success', 'synced' => 'check',
            'partial_success' => 'adjustments',
            'failed', 'retry' => 'warning',
            'queued' => 'queue',
            'sending' => 'sending',
            'pending' => 'clock',
            default => 'dot',
        };
    }

    public function getBatchStatusOptions(): array
    {
        return [
            '' => 'Semua status batch',
            'pending' => 'Menunggu dikirim',
            'queued' => 'Masuk queue',
            'sending' => 'Sedang dikirim',
            'partial_success' => 'Sebagian berhasil',
            'failed' => 'Gagal',
            'success' => 'Berhasil',
        ];
    }

    public function getOutboxStatusOptions(): array
    {
        return [
            '' => 'Semua status item',
            'pending' => 'Menunggu dikirim',
            'retry' => 'Perlu dicoba lagi',
            'synced' => 'Berhasil sinkron',
        ];
    }

    public function getEntityFilter(): ?string
    {
        $entity = trim((string) request()->query('entity', ''));

        return array_key_exists($entity, $this->getEntityOptions()) ? $entity : null;
    }

    public function getBatchStatusFilter(): ?string
    {
        $status = trim((string) request()->query('batch_status', ''));

        return array_key_exists($status, $this->getBatchStatusOptions()) && $status !== '' ? $status : null;
    }

    public function getOutboxStatusFilter(): ?string
    {
        $status = trim((string) request()->query('outbox_status', ''));

        return array_key_exists($status, $this->getOutboxStatusOptions()) && $status !== '' ? $status : null;
    }
}
