<?php

namespace App\Filament\Resources\TeacherPositions\Pages;

use App\Filament\Resources\TeacherPositions\TeacherPositionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeacherPositions extends ListRecords
{
    protected static string $resource = TeacherPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
