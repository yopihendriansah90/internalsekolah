<?php

namespace App\Filament\Resources\PpdbRegistrations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class PpdbRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('registration_number')
                    ->label('Nomor Pendaftaran')
                    ->searchable(),
                TextColumn::make('studentProfile.full_name')
                    ->label('Siswa')
                    ->searchable(),
                TextColumn::make('origin_school')
                    ->label('Asal Sekolah')
                    ->searchable(),
                TextColumn::make('entry_path')
                    ->label('Jalur Masuk')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('registration_date')
                    ->label('Tanggal')
                    ->date('d M Y'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
