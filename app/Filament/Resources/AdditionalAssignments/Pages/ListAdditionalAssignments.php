<?php

namespace App\Filament\Resources\AdditionalAssignments\Pages;

use App\Filament\Resources\AdditionalAssignments\AdditionalAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdditionalAssignments extends ListRecords
{
    protected static string $resource = AdditionalAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
