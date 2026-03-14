<?php

namespace App\Filament\Resources\TeacherPositions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeacherPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('teacher_profile_id')
                    ->label('Guru')
                    ->relationship('teacherProfile', 'full_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('position_id')
                    ->label('Jabatan')
                    ->relationship('position', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->native(false),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->native(false),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->required(),
                TextInput::make('decree_number')
                    ->label('Nomor SK')
                    ->maxLength(100),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
