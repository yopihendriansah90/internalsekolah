<?php

namespace App\Filament\Resources\IncomingLetterDispositions\Tables;

use App\Filament\Exports\IncomingLetterDispositionExporter;
use App\Support\Filament\AdminTable;
use App\Support\Filament\ExportActionFactory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class IncomingLetterDispositionsTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('letter.letter_number')
                    ->label('Nomor Surat')
                    ->searchable(),
                TextColumn::make('fromUser.name')
                    ->label('Dari')
                    ->searchable(),
                TextColumn::make('toUser.name')
                    ->label('Ke')
                    ->searchable(),
                TextColumn::make('instruction')
                    ->label('Instruksi')
                    ->limit(60),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('due_date')
                    ->label('Batas Waktu')
                    ->date('d M Y'),
                TextColumn::make('read_at')
                    ->label('Dibaca')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportActionFactory::make(IncomingLetterDispositionExporter::class, 'disposisi-surat-masuk'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
