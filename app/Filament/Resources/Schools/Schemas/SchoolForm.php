<?php

namespace App\Filament\Resources\Schools\Schemas;

use App\Enums\SchoolTypeEnum;
use App\Support\Filament\AdminSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SchoolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Profil Sekolah')
                    ->description('Bangun identitas utama sekolah yang dipakai di seluruh modul sistem.')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Sekolah')
                            ->required(),
                        TextInput::make('npsn')
                            ->label('NPSN')
                            ->maxLength(50),
                        Select::make('school_type')
                            ->label('Tipe Sekolah')
                            ->options(SchoolTypeEnum::options())
                            ->native(false)
                            ->required(),
                    ])
                    ->columns(2),
                AdminSection::make('Lokasi dan Kontak')
                    ->description('Pastikan alamat dan kanal komunikasi sekolah lengkap dan mudah diperiksa.')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat')
                            ->columnSpanFull(),
                        TextInput::make('village')
                            ->label('Kelurahan / Desa'),
                        TextInput::make('district')
                            ->label('Kecamatan'),
                        TextInput::make('city')
                            ->label('Kota / Kabupaten'),
                        TextInput::make('province')
                            ->label('Provinsi'),
                        TextInput::make('postal_code')
                            ->label('Kode Pos'),
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel(),
                        TextInput::make('email')
                            ->label('Email Sekolah')
                            ->email(),
                        TextInput::make('website')
                            ->label('Website')
                            ->url(),
                    ])
                    ->columns(2),
                AdminSection::make('Pimpinan Sekolah')
                    ->description('Simpan identitas kepala sekolah untuk kebutuhan administrasi dan cetak dokumen.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        TextInput::make('principal_name')
                            ->label('Nama Kepala Sekolah'),
                        TextInput::make('principal_nip')
                            ->label('NIP Kepala Sekolah'),
                    ])
                    ->columns(2),
            ]);
    }
}
