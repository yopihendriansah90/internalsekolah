<?php

namespace App\Filament\Resources\TeacherPositions\Schemas;

use App\Support\Filament\AdminSection;
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
                AdminSection::make('Penugasan Jabatan Guru')
                    ->description('Hubungkan guru dengan jabatan formal yang sedang atau pernah dijalankan.')
                    ->icon('heroicon-o-identification')
                    ->schema([
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
                    ])
                    ->columns(2),
                AdminSection::make('Legalitas dan Status')
                    ->description('Simpan nomor SK, status aktif, dan catatan administratif lainnya.')
                    ->icon('heroicon-o-document-check')
                    ->schema([
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
                    ->columns(2),
            ]);
    }
}
