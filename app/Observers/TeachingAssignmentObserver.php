<?php

namespace App\Observers;

use App\Models\TeachingAssignment;
use App\Services\Sync\MasterDataSyncService;

class TeachingAssignmentObserver
{
    public function saved(TeachingAssignment $teachingAssignment): void
    {
        app(MasterDataSyncService::class)->enqueueModel('teaching_assignment', $teachingAssignment);
    }

    public function deleting(TeachingAssignment $teachingAssignment): void
    {
        app(MasterDataSyncService::class)->enqueueModel('teaching_assignment', $teachingAssignment, 'deactivate');
    }
}
