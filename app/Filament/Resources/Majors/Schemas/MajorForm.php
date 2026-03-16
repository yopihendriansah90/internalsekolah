<?php

namespace App\Filament\Resources\Majors\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MajorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Identitas Struktur Akademik')
                    ->description('Jelaskan nama, kode, dan pengelompokan struktur akademik yang dipakai sekolah.')
                    ->icon('heroicon-o-squares-2x2')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode')
                            ->required(),
                        TextInput::make('short_name')
                            ->label('Nama Singkat'),
                        Select::make('education_level')
                            ->label('Jenjang')
                            ->options([
                                'SMA' => 'SMA',
                                'SMK' => 'SMK',
                            ])
                            ->default('SMA')
                            ->required(),
                        Select::make('major_type')
                            ->label('Tipe Struktur')
                            ->options([
                                'jurusan' => 'Jurusan',
                                'peminatan' => 'Peminatan',
                                'umum' => 'Umum',
                            ])
                            ->default('jurusan')
                            ->required(),
                        TextInput::make('department_group')
                            ->label('Kelompok'),
                    ])
                    ->columns(2),
                AdminSection::make('Keterangan')
                    ->description('Tambahkan ringkasan konteks dan status aktif agar mudah dipelihara.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
