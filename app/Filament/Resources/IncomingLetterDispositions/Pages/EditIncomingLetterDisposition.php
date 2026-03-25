<?php

namespace App\Filament\Resources\IncomingLetterDispositions\Pages;

use App\Filament\Resources\IncomingLetterDispositions\IncomingLetterDispositionResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use Filament\Actions\DeleteAction;

class EditIncomingLetterDisposition extends BaseEditRecord
{
    protected static string $resource = IncomingLetterDispositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
