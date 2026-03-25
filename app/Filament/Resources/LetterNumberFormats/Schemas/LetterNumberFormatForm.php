<?php

namespace App\Filament\Resources\LetterNumberFormats\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LetterNumberFormatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Format Nomor Surat')
                    ->description('Atur pola penomoran otomatis surat berdasarkan kategori.')
                    ->icon('heroicon-o-hashtag')
                    ->schema([
                        Select::make('letter_category_id')
                            ->label('Kategori Surat')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('Nama Format')
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode Format')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('format_pattern')
                            ->label('Pola Nomor')
                            ->placeholder('{seq}/SK/{month}/{year}')
                            ->required(),
                        Select::make('sequence_reset_period')
                            ->label('Reset Nomor')
                            ->options([
                                'yearly' => 'Tahunan',
                                'monthly' => 'Bulanan',
                                'never' => 'Tidak Pernah',
                            ])
                            ->default('yearly')
                            ->native(false)
                            ->required(),
                        TextInput::make('current_sequence')
                            ->label('Nomor Berjalan Saat Ini')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
