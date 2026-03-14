<?php

namespace App\Filament\Resources\TeachingAssignments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeachingAssignmentForm
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
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('classroom_id')
                    ->label('Kelas / Rombel')
                    ->relationship('classroom', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('semester_id')
                    ->label('Semester')
                    ->relationship('semester', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('hours_per_week')
                    ->label('Jam per Minggu')
                    ->numeric(),
                Select::make('assignment_status')
                    ->label('Status Penugasan')
                    ->options([
                        'aktif' => 'Aktif',
                        'direncanakan' => 'Direncanakan',
                        'selesai' => 'Selesai',
                    ])
                    ->native(false)
                    ->default('aktif')
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->native(false),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->native(false),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
