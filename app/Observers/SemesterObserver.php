<?php

namespace App\Observers;

use App\Models\Semester;
use App\Services\Sync\MasterDataSyncService;

class SemesterObserver
{
    public function saved(Semester $semester): void
    {
        app(MasterDataSyncService::class)->enqueueModel('semester', $semester);
    }

    public function deleting(Semester $semester): void
    {
        app(MasterDataSyncService::class)->enqueueModel('semester', $semester, 'deactivate');
    }
}
