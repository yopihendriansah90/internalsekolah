<?php

namespace App\Filament\Resources\LetterCategories\Pages;

use App\Filament\Resources\LetterCategories\LetterCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLetterCategories extends ListRecords
{
    protected static string $resource = LetterCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
