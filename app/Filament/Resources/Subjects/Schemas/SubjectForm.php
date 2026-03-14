<?php

namespace App\Filament\Resources\Subjects\Schemas;

use App\Enums\SubjectGroupEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Mata Pelajaran')
                    ->required(),
                TextInput::make('code')
                    ->label('Kode Mata Pelajaran')
                    ->required(),
                TextInput::make('education_level')
                    ->label('Jenjang'),
                Select::make('school_type_scope')
                    ->label('Cakupan Tipe Sekolah')
                    ->options([
                        'ALL' => 'Semua',
                        'SMA' => 'SMA',
                        'SMK' => 'SMK',
                    ])
                    ->native(false)
                    ->required()
                    ->default('ALL'),
                Select::make('subject_group')
                    ->label('Kelompok Mata Pelajaran')
                    ->options(SubjectGroupEnum::options())
                    ->native(false)
                    ->default(SubjectGroupEnum::Umum->value)
                    ->required(),
                Select::make('major_id')
                    ->label('Struktur Akademik Terkait')
                    ->relationship('major', 'name')
                    ->searchable()
                    ->preload(),
                Toggle::make('is_productive')
                    ->label('Mapel Produktif')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
