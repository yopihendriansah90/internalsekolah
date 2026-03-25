<?php

namespace App\Filament\Resources\Letters\Tables;

use App\Filament\Exports\LetterExporter;
use App\Support\Filament\AdminTable;
use App\Support\Filament\ExportActionFactory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LettersTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('letter_number')
                    ->label('Nomor Surat')
                    ->searchable(),
                TextColumn::make('agenda_number')
                    ->label('Nomor Agenda')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Perihal')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('direction')
                    ->label('Arah')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('letter_date')
                    ->label('Tanggal Surat')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('sender_name')
                    ->label('Pengirim')
                    ->searchable(),
                TextColumn::make('recipient_name')
                    ->label('Penerima')
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportActionFactory::make(LetterExporter::class, 'surat'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
