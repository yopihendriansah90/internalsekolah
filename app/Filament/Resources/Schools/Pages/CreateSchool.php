<?php

namespace App\Filament\Resources\Schools\Pages;

use App\Filament\Resources\Schools\SchoolResource;
use App\Filament\Resources\Pages\BaseCreateRecord;
use App\Models\SystemSetting;

class CreateSchool extends BaseCreateRecord
{
    protected static string $resource = SchoolResource::class;

    public function mount(): void
    {
        $record = SchoolResource::getSingletonRecord();

        if ($record) {
            $this->redirect(SchoolResource::getUrl('edit', ['record' => $record]));

            return;
        }

        parent::mount();
    }

    protected function afterCreate(): void
    {
        SystemSetting::putValue('default_locale', app()->getLocale(), 'string', true);
    }
}
