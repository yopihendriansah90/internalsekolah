<?php

namespace App\Filament\Resources\Schools\Schemas;

use App\Enums\SchoolTypeEnum;
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
                TextInput::make('principal_name')
                    ->label('Nama Kepala Sekolah'),
                TextInput::make('principal_nip')
                    ->label('NIP Kepala Sekolah'),
            ])
            ->columns(2);
    }
}
