<?php

namespace App\Jobs;

use App\Services\Sync\MasterDataSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;

class SendEduSyncBatchJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    public function __construct(
        public readonly string $batchId,
        public readonly int $limit = 100,
    ) {
    }

    public function handle(MasterDataSyncService $syncService): void
    {
        $result = $syncService->sendBatch($this->batchId, $this->limit);

        if (($result['remaining'] ?? 0) > 0) {
            self::dispatch($this->batchId, $this->limit);
        }
    }
}
