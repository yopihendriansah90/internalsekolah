<?php

namespace App\Filament\Resources\LetterNumberFormats\Tables;

use App\Filament\Exports\LetterNumberFormatExporter;
use App\Support\Filament\AdminTable;
use App\Support\Filament\ExportActionFactory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LetterNumberFormatsTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->label('Nama Format')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('format_pattern')
                    ->label('Pola')
                    ->searchable(),
                TextColumn::make('current_sequence')
                    ->label('No. Berjalan')
                    ->numeric(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportActionFactory::make(LetterNumberFormatExporter::class, 'format-nomor-surat'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
