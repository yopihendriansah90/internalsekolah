<?php

namespace App\Observers;

use App\Models\Classroom;
use App\Services\Sync\MasterDataSyncService;

class ClassroomObserver
{
    public function saved(Classroom $classroom): void
    {
        app(MasterDataSyncService::class)->enqueueModel('classroom', $classroom);
    }

    public function deleting(Classroom $classroom): void
    {
        app(MasterDataSyncService::class)->enqueueModel('classroom', $classroom, 'deactivate');
    }
}
