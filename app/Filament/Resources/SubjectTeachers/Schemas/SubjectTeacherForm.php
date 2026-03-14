<?php

namespace App\Filament\Resources\SubjectTeachers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SubjectTeacherForm
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
                Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'name')
                    ->searchable()
                    ->preload(),
                Textarea::make('competency_notes')
                    ->label('Catatan Kompetensi')
                    ->rows(3),
                Textarea::make('notes')
                    ->label('Catatan Tambahan')
                    ->rows(3),
            ])
            ->columns(2);
    }
}
