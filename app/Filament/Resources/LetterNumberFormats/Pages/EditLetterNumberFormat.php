<?php

namespace App\Filament\Resources\LetterNumberFormats\Pages;

use App\Filament\Resources\LetterNumberFormats\LetterNumberFormatResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use Filament\Actions\DeleteAction;

class EditLetterNumberFormat extends BaseEditRecord
{
    protected static string $resource = LetterNumberFormatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
