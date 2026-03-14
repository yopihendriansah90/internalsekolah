<?php

namespace App\Filament\Resources\TeacherPositions\Pages;

use App\Filament\Resources\TeacherPositions\TeacherPositionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacherPosition extends EditRecord
{
    protected static string $resource = TeacherPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
