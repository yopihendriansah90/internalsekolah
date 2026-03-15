<?php

namespace App\Filament\Resources\Schools\Pages;

use App\Filament\Resources\Schools\SchoolResource;
use Filament\Resources\Pages\ListRecords;

class ListSchools extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = SchoolResource::getSingletonRecord();

        if ($record) {
            $this->redirect(SchoolResource::getUrl('edit', ['record' => $record]));

            return;
        }

        $this->redirect(SchoolResource::getUrl('create'));
    }
}
