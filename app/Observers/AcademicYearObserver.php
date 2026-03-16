<?php

namespace App\Observers;

use App\Models\AcademicYear;
use App\Services\Sync\MasterDataSyncService;

class AcademicYearObserver
{
    public function saved(AcademicYear $academicYear): void
    {
        app(MasterDataSyncService::class)->enqueueModel('academic_year', $academicYear);
    }

    public function deleting(AcademicYear $academicYear): void
    {
        app(MasterDataSyncService::class)->enqueueModel('academic_year', $academicYear, 'deactivate');
    }
}
