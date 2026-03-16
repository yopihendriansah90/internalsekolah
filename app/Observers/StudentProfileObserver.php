<?php

namespace App\Observers;

use App\Models\StudentProfile;
use App\Services\Sync\MasterDataSyncService;

class StudentProfileObserver
{
    public function saved(StudentProfile $studentProfile): void
    {
        app(MasterDataSyncService::class)->enqueueModel('student', $studentProfile);
    }

    public function deleting(StudentProfile $studentProfile): void
    {
        app(MasterDataSyncService::class)->enqueueModel('student', $studentProfile, 'deactivate');
    }
}
