<?php

namespace App\Observers;

use App\Models\Subject;
use App\Services\Sync\MasterDataSyncService;

class SubjectObserver
{
    public function saved(Subject $subject): void
    {
        app(MasterDataSyncService::class)->enqueueModel('subject', $subject);
    }

    public function deleting(Subject $subject): void
    {
        app(MasterDataSyncService::class)->enqueueModel('subject', $subject, 'deactivate');
    }
}
