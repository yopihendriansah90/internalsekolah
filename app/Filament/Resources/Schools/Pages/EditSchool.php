<?php

namespace App\Filament\Resources\Schools\Pages;

use App\Filament\Resources\Pages\BaseEditRecord;
use App\Filament\Resources\Schools\SchoolResource;
use App\Models\SystemSetting;

class EditSchool extends BaseEditRecord
{
    protected static string $resource = SchoolResource::class;

    protected function afterSave(): void
    {
        SystemSetting::putValue('default_locale', app()->getLocale(), 'string', true);
    }
}
