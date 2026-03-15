<?php

namespace App\Filament\Resources\AdditionalAssignments\Pages;

use App\Filament\Resources\AdditionalAssignments\AdditionalAssignmentResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use Filament\Actions\DeleteAction;

class EditAdditionalAssignment extends BaseEditRecord
{
    protected static string $resource = AdditionalAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
