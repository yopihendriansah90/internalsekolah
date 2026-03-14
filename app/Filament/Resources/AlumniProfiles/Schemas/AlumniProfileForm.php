<?php

namespace App\Filament\Resources\AlumniProfiles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AlumniProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_profile_id')
                    ->label('Siswa')
                    ->relationship('studentProfile', 'full_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('graduation_year')
                    ->label('Tahun Lulus')
                    ->numeric(),
                TextInput::make('certificate_number')
                    ->label('Nomor Ijazah')
                    ->maxLength(100),
                TextInput::make('destination_after_graduation')
                    ->label('Tujuan Setelah Lulus')
                    ->maxLength(255),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
