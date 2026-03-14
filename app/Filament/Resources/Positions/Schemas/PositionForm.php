<?php

namespace App\Filament\Resources\Positions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Jabatan')
                    ->required(),
                TextInput::make('code')
                    ->label('Kode Jabatan')
                    ->required(),
                TextInput::make('type')
                    ->label('Tipe Jabatan'),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
