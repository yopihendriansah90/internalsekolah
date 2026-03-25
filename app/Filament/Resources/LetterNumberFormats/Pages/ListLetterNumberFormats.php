<?php

namespace App\Filament\Resources\LetterNumberFormats\Pages;

use App\Filament\Resources\LetterNumberFormats\LetterNumberFormatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLetterNumberFormats extends ListRecords
{
    protected static string $resource = LetterNumberFormatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
