<?php

namespace App\Filament\Resources\AdditionalAssignments\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AdditionalAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Penugasan Tambahan')
                    ->description('Hubungkan guru dengan peran tambahan yang sedang dijalankan.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        Select::make('teacher_profile_id')
                            ->label('Guru')
                            ->relationship('teacherProfile', 'full_name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('assignment_type')
                            ->label('Jenis Tugas')
                            ->options([
                                'wali_kelas' => 'Wali Kelas',
                                'pembina' => 'Pembina',
                                'koordinator' => 'Koordinator',
                                'kaprog' => 'Kepala Program',
                            ])
                            ->native(false)
                            ->required(),
                        Select::make('classroom_id')
                            ->label('Kelas Terkait')
                            ->relationship('classroom', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),
                AdminSection::make('Masa Berlaku')
                    ->description('Atur periode tugas dan catatan operasional bila diperlukan.')
                    ->icon('heroicon-o-clock')
                    ->schema([
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
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
