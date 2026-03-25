<?php

namespace App\Filament\Resources\Letters\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LetterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Informasi Surat')
                    ->description('Simpan metadata utama surat dinas.')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        Hidden::make('created_by_user_id')
                            ->default(fn (): ?int => auth()->id())
                            ->dehydrated(fn (?int $state): bool => filled($state)),
                        Select::make('letter_category_id')
                            ->label('Kategori Surat')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('letter_template_id')
                            ->label('Template Surat')
                            ->relationship('template', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('letter_number_format_id')
                            ->label('Format Nomor Surat')
                            ->relationship('numberFormat', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('letter_number')
                            ->label('Nomor Surat')
                            ->maxLength(255),
                        TextInput::make('agenda_number')
                            ->label('Nomor Agenda')
                            ->maxLength(100),
                        TextInput::make('subject')
                            ->label('Perihal')
                            ->required(),
                        Select::make('direction')
                            ->label('Arah Surat')
                            ->options([
                                'outgoing' => 'Surat Keluar',
                                'incoming' => 'Surat Masuk',
                                'internal' => 'Internal',
                            ])
                            ->default('outgoing')
                            ->native(false)
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'review' => 'Review',
                                'approved' => 'Disetujui',
                                'signed' => 'Ditandatangani',
                                'sent' => 'Terkirim',
                                'archived' => 'Arsip',
                            ])
                            ->default('draft')
                            ->native(false)
                            ->required(),
                        DatePicker::make('letter_date')
                            ->label('Tanggal Surat'),
                        TextInput::make('sender_name')
                            ->label('Nama Pengirim'),
                        TextInput::make('recipient_name')
                            ->label('Nama Penerima'),
                        TextInput::make('signed_by_name')
                            ->label('Ditandatangani Oleh'),
                        Textarea::make('content')
                            ->label('Isi Surat')
                            ->rows(12)
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                        DateTimePicker::make('approved_at')
                            ->label('Tanggal Disetujui'),
                        DateTimePicker::make('signed_at')
                            ->label('Tanggal Ditandatangani'),
                        DateTimePicker::make('issued_at')
                            ->label('Tanggal Diterbitkan'),
                    ])
                    ->columns(2),
            ]);
    }
}
