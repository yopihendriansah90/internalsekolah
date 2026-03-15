<?php

namespace App\Filament\Resources\Semesters\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SemesterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Detail Semester')
                    ->description('Hubungkan semester dengan tahun ajaran dan identitas kode resminya.')
                    ->icon('heroicon-o-calendar')
                    ->schema([
                        Select::make('academic_year_id')
                            ->label('Tahun Ajaran')
                            ->relationship('academicYear', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama Semester')
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode Semester')
                            ->required(),
                    ])
                    ->columns(2),
                AdminSection::make('Status')
                    ->description('Aktifkan semester yang sedang digunakan dalam proses akademik.')
                    ->icon('heroicon-o-bolt')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->required(),
                    ]),
            ]);
    }
}
