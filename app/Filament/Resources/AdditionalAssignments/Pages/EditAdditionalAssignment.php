<?php

namespace App\Filament\Resources\AdditionalAssignments\Pages;

use App\Filament\Resources\AdditionalAssignments\AdditionalAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdditionalAssignment extends EditRecord
{
    protected static string $resource = AdditionalAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
