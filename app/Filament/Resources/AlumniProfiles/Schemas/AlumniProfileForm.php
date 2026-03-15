<?php

namespace App\Filament\Resources\AlumniProfiles\Schemas;

use App\Support\Filament\AdminSection;
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
                AdminSection::make('Profil Alumni')
                    ->description('Tetapkan siswa yang sudah lulus beserta identitas kelulusannya.')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
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
                    ])
                    ->columns(2),
                AdminSection::make('Tindak Lanjut')
                    ->description('Simpan tujuan pasca kelulusan dan catatan penting alumni.')
                    ->icon('heroicon-o-arrow-trending-up')
                    ->schema([
                        TextInput::make('destination_after_graduation')
                            ->label('Tujuan Setelah Lulus')
                            ->maxLength(255),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
