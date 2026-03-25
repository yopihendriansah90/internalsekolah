<?php

namespace App\Filament\Resources\IncomingLetterDispositions\Pages;

use App\Filament\Resources\IncomingLetterDispositions\IncomingLetterDispositionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIncomingLetterDispositions extends ListRecords
{
    protected static string $resource = IncomingLetterDispositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
