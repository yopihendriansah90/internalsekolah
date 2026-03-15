<?php

namespace App\Filament\Resources\SubjectTeachers\Pages;

use App\Filament\Resources\SubjectTeachers\SubjectTeacherResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use Filament\Actions\DeleteAction;

class EditSubjectTeacher extends BaseEditRecord
{
    protected static string $resource = SubjectTeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
