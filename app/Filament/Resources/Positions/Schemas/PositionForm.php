<?php

namespace App\Filament\Resources\Positions\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Identitas Jabatan')
                    ->description('Definisikan jabatan yang akan dipakai untuk penugasan guru atau staf.')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Jabatan')
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode Jabatan')
                            ->required(),
                        TextInput::make('type')
                            ->label('Tipe Jabatan'),
                    ])
                    ->columns(2),
                AdminSection::make('Deskripsi Jabatan')
                    ->description('Ringkas fungsi atau ruang lingkup jabatan agar tidak ambigu saat dipilih.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
