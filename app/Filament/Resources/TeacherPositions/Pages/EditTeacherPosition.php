<?php

namespace App\Filament\Resources\TeacherPositions\Pages;

use App\Filament\Resources\TeacherPositions\TeacherPositionResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use Filament\Actions\DeleteAction;

class EditTeacherPosition extends BaseEditRecord
{
    protected static string $resource = TeacherPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
