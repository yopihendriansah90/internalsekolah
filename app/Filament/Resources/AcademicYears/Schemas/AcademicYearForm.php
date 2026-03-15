<?php

namespace App\Filament\Resources\AcademicYears\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AcademicYearForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Periode Akademik')
                    ->description('Tentukan identitas tahun ajaran dan rentang waktu berjalannya.')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tahun Ajaran')
                            ->required(),
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required(),
                    ])
                    ->columns(2),
                AdminSection::make('Status Publikasi')
                    ->description('Tandai tahun ajaran aktif agar mudah dikenali sistem dan operator.')
                    ->icon('heroicon-o-bolt')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->required(),
                    ]),
            ]);
    }
}
