<?php

namespace App\Filament\Resources\IncomingLetterDispositions\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class IncomingLetterDispositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Disposisi Surat Masuk')
                    ->description('Distribusikan instruksi tindak lanjut untuk surat masuk.')
                    ->icon('heroicon-o-inbox-arrow-down')
                    ->schema([
                        Select::make('letter_id')
                            ->label('Surat')
                            ->relationship('letter', 'subject')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('from_user_id')
                            ->label('Dari Pengguna')
                            ->relationship('fromUser', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('to_user_id')
                            ->label('Ke Pengguna')
                            ->relationship('toUser', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'dibaca' => 'Dibaca',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                            ])
                            ->default('pending')
                            ->native(false)
                            ->required(),
                        DatePicker::make('due_date')
                            ->label('Batas Waktu'),
                        Textarea::make('instruction')
                            ->label('Instruksi')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                        DateTimePicker::make('read_at')
                            ->label('Dibaca Pada'),
                        DateTimePicker::make('completed_at')
                            ->label('Selesai Pada'),
                    ])
                    ->columns(2),
            ]);
    }
}
