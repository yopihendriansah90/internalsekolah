<?php

namespace App\Filament\Resources\LetterCategories\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LetterCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Identitas Kategori Surat')
                    ->description('Kelompokkan tipe surat agar alur administrasi lebih rapi.')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode Kategori')
                            ->helperText('Dipakai untuk kebutuhan internal sistem dan tidak ditampilkan di dokumen surat.')
                            ->required()
                            ->maxLength(50),
                        Select::make('scope')
                            ->label('Ruang Lingkup')
                            ->options([
                                'umum' => 'Umum',
                                'guru' => 'Guru',
                                'siswa' => 'Siswa',
                            ])
                            ->default('umum')
                            ->native(false)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
