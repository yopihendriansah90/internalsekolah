<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PpdbRegistrationForm
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
                TextInput::make('registration_number')
                    ->label('Nomor Pendaftaran')
                    ->required()
                    ->maxLength(100),
                DatePicker::make('registration_date')
                    ->label('Tanggal Pendaftaran')
                    ->native(false),
                TextInput::make('origin_school')
                    ->label('Asal Sekolah'),
                Select::make('entry_path')
                    ->label('Jalur Masuk')
                    ->options([
                        'zonasi' => 'Zonasi',
                        'prestasi' => 'Prestasi',
                        'afirmasi' => 'Afirmasi',
                        'reguler' => 'Reguler',
                    ])
                    ->native(false),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'terdaftar' => 'Terdaftar',
                        'terverifikasi' => 'Terverifikasi',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->native(false)
                    ->default('terdaftar')
                    ->required(),
                DatePicker::make('documents_verified_at')
                    ->label('Tanggal Verifikasi Dokumen')
                    ->native(false),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
