<?php

namespace App\Filament\Resources\Classrooms\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClassroomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Struktur Kelas')
                    ->description('Susun identitas rombel agar mudah dicari oleh operator dan guru.')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Select::make('academic_year_id')
                            ->label('Tahun Ajaran')
                            ->relationship('academicYear', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('major_id')
                            ->label('Struktur Akademik')
                            ->relationship('major', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('Nama Kelas / Rombel')
                            ->required()
                            ->maxLength(255),
                        Select::make('grade_level')
                            ->label('Tingkat')
                            ->options([
                                'X' => 'X',
                                'XI' => 'XI',
                                'XII' => 'XII',
                            ])
                            ->native(false)
                            ->required(),
                        TextInput::make('capacity')
                            ->label('Kapasitas')
                            ->numeric()
                            ->default(36)
                            ->required(),
                    ])
                    ->columns(2),
                AdminSection::make('Pengelolaan Kelas')
                    ->description('Atur penanggung jawab dan status kelas untuk periode berjalan.')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        Select::make('homeroom_teacher_id')
                            ->label('Wali Kelas')
                            ->relationship('homeroomTeacher', 'full_name')
                            ->searchable()
                            ->preload(),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
