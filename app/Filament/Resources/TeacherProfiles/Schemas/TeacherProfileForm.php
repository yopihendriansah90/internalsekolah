<?php

namespace App\Filament\Resources\TeacherProfiles\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeacherProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Identitas Guru')
                    ->description('Lengkapi profil dasar guru agar seluruh modul penugasan dan akademik sinkron.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('user_id')
                            ->label('Akun Pengguna')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('employee_number')
                            ->label('Nomor Induk Pegawai')
                            ->maxLength(50),
                        TextInput::make('nip')
                            ->label('NIP')
                            ->maxLength(50),
                        TextInput::make('nuptk')
                            ->label('NUPTK')
                            ->maxLength(50),
                        TextInput::make('dapodik_id')
                            ->label('ID Dapodik')
                            ->maxLength(100),
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
                    ->description('Simpan kontak, status kepegawaian, dan catatan operasional guru.')
                    ->icon('heroicon-o-briefcase')
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
                        TextInput::make('education_last')
                            ->label('Pendidikan Terakhir')
                            ->maxLength(100),
                        Select::make('employment_status')
                            ->label('Status Kepegawaian')
                            ->options([
                                'tetap' => 'Tetap',
                                'honorer' => 'Honorer',
                                'pppk' => 'PPPK',
                                'kontrak' => 'Kontrak',
                            ])
                            ->native(false),
                        Select::make('teacher_status')
                            ->label('Status Guru')
                            ->options([
                                'guru_mapel' => 'Guru Mata Pelajaran',
                                'wali_kelas' => 'Wali Kelas',
                                'bk' => 'Guru BK',
                                'produktif' => 'Guru Produktif',
                            ])
                            ->native(false),
                        DatePicker::make('join_date')
                            ->label('Tanggal Bergabung')
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
