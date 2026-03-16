<?php

namespace App\Observers;

use App\Models\StudentClassHistory;
use App\Services\Sync\MasterDataSyncService;

class StudentClassHistoryObserver
{
    public function saved(StudentClassHistory $studentClassHistory): void
    {
        app(MasterDataSyncService::class)->enqueueModel('student_class_membership', $studentClassHistory);
    }

    public function deleting(StudentClassHistory $studentClassHistory): void
    {
        app(MasterDataSyncService::class)->enqueueModel('student_class_membership', $studentClassHistory, 'deactivate');
    }
}
