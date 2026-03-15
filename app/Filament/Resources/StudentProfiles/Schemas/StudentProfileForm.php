<?php

namespace App\Filament\Resources\StudentProfiles\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StudentProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Identitas Siswa')
                    ->description('Lengkapi identitas utama siswa sebagai dasar seluruh modul akademik.')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nis')
                            ->label('NIS')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('nisn')
                            ->label('NISN')
                            ->maxLength(50),
                        TextInput::make('registration_number')
                            ->label('Nomor Pendaftaran')
                            ->maxLength(100),
                        TextInput::make('dapodik_id')
                            ->label('ID Dapodik')
                            ->maxLength(100),
                        Select::make('major_id')
                            ->label('Struktur Akademik')
                            ->relationship('major', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->maxLength(100),
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->native(false),
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->native(false),
                        TextInput::make('religion')
                            ->label('Agama')
                            ->maxLength(50),
                    ])
                    ->columns(2),
                AdminSection::make('Kontak dan Status')
                    ->description('Simpan informasi komunikasi, wali, dan status administrasi siswa.')
                    ->icon('heroicon-o-phone')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(50),
                        TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('guardian_name')
                            ->label('Nama Wali')
                            ->maxLength(255),
                        TextInput::make('guardian_phone')
                            ->label('Telepon Wali')
                            ->tel()
                            ->maxLength(50),
                        TextInput::make('entry_year')
                            ->label('Tahun Masuk')
                            ->numeric(),
                        Select::make('student_status')
                            ->label('Status Siswa')
                            ->options([
                                'aktif' => 'Aktif',
                                'pindah' => 'Pindah',
                                'lulus' => 'Lulus',
                                'nonaktif' => 'Nonaktif',
                            ])
                            ->native(false)
                            ->default('aktif')
                            ->required(),
                        Select::make('ppdb_status')
                            ->label('Status PPDB')
                            ->options([
                                'draft' => 'Draft',
                                'terverifikasi' => 'Terverifikasi',
                                'diterima' => 'Diterima',
                                'ditolak' => 'Ditolak',
                            ])
                            ->native(false)
                            ->default('draft')
                            ->required(),
                        TextInput::make('graduation_year')
                            ->label('Tahun Lulus')
                            ->numeric(),
                        Toggle::make('is_alumni')
                            ->label('Alumni')
                            ->default(false),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
