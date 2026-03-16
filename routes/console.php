<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\Sync\MasterDataSyncService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sync:enqueue-master-data {--entity=*}', function (MasterDataSyncService $syncService) {
    $result = $syncService->enqueue($this->option('entity'));

    $this->info('Outbox sinkronisasi berhasil diperbarui.');
    $this->line("Batch ID : {$result['batch_id']}");
    $this->line("Queued   : {$result['queued']}");
    $this->line("Updated  : {$result['updated']}");
    $this->line("Skipped  : {$result['skipped']}");
})->purpose('Menambahkan master data internal ke sync outbox untuk EDUSYNC OS');

Artisan::command('sync:send-master-data {--limit=100} {--batch-limit=1} {--now}', function (MasterDataSyncService $syncService) {
    if ($this->option('now')) {
        $result = $syncService->sendPending((int) $this->option('limit'));

        $this->info('Pengiriman sinkronisasi ke EDUSYNC OS selesai.');
        $this->line("Batch ID : {$result['batch_id']}");
        $this->line("Status   : {$result['status']}");
        $this->line("Total    : {$result['total']}");
        $this->line("Success  : {$result['success']}");
        $this->line("Failed   : {$result['failed']}");
        $this->line("Remain   : {$result['remaining']}");

        return;
    }

    $result = $syncService->dispatchPendingBatches(
        (int) $this->option('limit'),
        (int) $this->option('batch-limit'),
    );

    $this->info('Batch sinkronisasi berhasil dimasukkan ke queue.');
    $this->line("Queued batch : {$result['queued_batches']}");
    $this->line("Queued item  : {$result['queued_items']}");
    $this->line('Batch IDs    : '.($result['batch_ids'] === [] ? '-' : implode(', ', $result['batch_ids'])));
})->purpose('Memasukkan item pending di sync outbox ke queue pengiriman EDUSYNC OS');
