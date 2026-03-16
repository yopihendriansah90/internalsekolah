<?php

namespace App\Observers;

use App\Models\TeacherProfile;
use App\Services\Sync\MasterDataSyncService;

class TeacherProfileObserver
{
    public function saved(TeacherProfile $teacherProfile): void
    {
        app(MasterDataSyncService::class)->enqueueModel('teacher', $teacherProfile);
    }

    public function deleting(TeacherProfile $teacherProfile): void
    {
        app(MasterDataSyncService::class)->enqueueModel('teacher', $teacherProfile, 'deactivate');
    }
}
