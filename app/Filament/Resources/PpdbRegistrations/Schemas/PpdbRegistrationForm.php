<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use App\Support\Filament\AdminSection;
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
                AdminSection::make('Registrasi PPDB')
                    ->description('Masukkan identitas pendaftaran dan jalur seleksi calon siswa.')
                    ->icon('heroicon-o-document-check')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('registration_number')
                            ->label('Nomor Pendaftaran (Otomatis)')
                            ->placeholder('Akan dibuat otomatis saat data disimpan')
                            ->helperText('Nomor pendaftaran dibuat otomatis oleh sistem saat proses simpan.')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('nisn')
                            ->label('NISN')
                            ->maxLength(50),
                        DatePicker::make('registration_date')
                            ->label('Tanggal Pendaftaran')
                            ->default(now())
                            ->native(false),
                        TextInput::make('origin_school')
                            ->label('Asal Sekolah'),
                        Select::make('major_id')
                            ->label('Pilihan Struktur Akademik')
                            ->relationship('major', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('entry_path')
                            ->label('Jalur Masuk')
                            ->options([
                                'zonasi' => 'Zonasi',
                                'prestasi' => 'Prestasi',
                                'afirmasi' => 'Afirmasi',
                                'reguler' => 'Reguler',
                            ])
                            ->native(false),
                    ])
                    ->columns(2),
                AdminSection::make('Identitas Calon Siswa')
                    ->description('Simpan data calon siswa sejak proses pendaftaran berlangsung.')
                    ->icon('heroicon-o-identification')
                    ->schema([
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
                AdminSection::make('Kontak dan Wali')
                    ->description('Informasi ini dipakai saat proses verifikasi hingga siswa resmi diterima.')
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
                    ])
                    ->columns(2),
                AdminSection::make('Verifikasi dan Keputusan')
                    ->description('Pantau tahapan verifikasi dokumen dan hasil akhir penerimaan.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'terdaftar' => 'Terdaftar',
                                'terverifikasi' => 'Terverifikasi',
                                'ditolak' => 'Ditolak',
                            ])
                            ->native(false)
                            ->default('terdaftar')
                            ->required()
                            ->helperText('Status "Diterima" ditetapkan otomatis melalui aksi "Terima Sebagai Siswa".'),
                        DatePicker::make('documents_verified_at')
                            ->label('Tanggal Verifikasi Dokumen')
                            ->native(false),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
