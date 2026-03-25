<?php

namespace App\Filament\Resources\LetterTemplates\Schemas;

use App\Support\Filament\AdminSection;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LetterTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                AdminSection::make('Template Surat')
                    ->description('Kelola template isi surat beserta placeholder dinamisnya.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Select::make('letter_category_id')
                            ->label('Kategori Surat')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('Nama Template')
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode Template')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('subject_template')
                            ->label('Template Perihal'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                        Textarea::make('body_html')
                            ->label('Isi Template')
                            ->rows(12)
                            ->columnSpanFull(),
                        KeyValue::make('placeholders')
                            ->label('Placeholder')
                            ->keyLabel('Placeholder')
                            ->valueLabel('Keterangan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
