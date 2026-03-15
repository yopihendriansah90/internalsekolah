<?php

namespace App\Filament\Resources\StudentClassHistories\Pages;

use App\Filament\Resources\StudentClassHistories\StudentClassHistoryResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use Filament\Actions\DeleteAction;

class EditStudentClassHistory extends BaseEditRecord
{
    protected static string $resource = StudentClassHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
