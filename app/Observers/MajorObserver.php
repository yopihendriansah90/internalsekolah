<?php

namespace App\Observers;

use App\Models\Major;
use App\Services\Sync\MasterDataSyncService;

class MajorObserver
{
    public function saved(Major $major): void
    {
        app(MasterDataSyncService::class)->enqueueModel('major', $major);
    }

    public function deleting(Major $major): void
    {
        app(MasterDataSyncService::class)->enqueueModel('major', $major, 'deactivate');
    }
}
