<?php

namespace App\Filament\Resources\Schools\Pages;

use App\Filament\Resources\Pages\BaseEditRecord;
use App\Filament\Resources\Schools\SchoolResource;
use Filament\Actions\DeleteAction;

class EditSchool extends BaseEditRecord
{
    protected static string $resource = SchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
