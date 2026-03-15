<?php

namespace App\Filament\Resources\StudentProfiles\Pages;

use App\Filament\Resources\StudentProfiles\StudentProfileResource;
use App\Filament\Resources\Pages\BaseCreateRecord;

class CreateStudentProfile extends BaseCreateRecord
{
    protected static string $resource = StudentProfileResource::class;
}
