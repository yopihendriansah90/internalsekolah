<?php

namespace App\Filament\Resources\LetterCategories\Pages;

use App\Filament\Resources\LetterCategories\LetterCategoryResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use Filament\Actions\DeleteAction;

class EditLetterCategory extends BaseEditRecord
{
    protected static string $resource = LetterCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
