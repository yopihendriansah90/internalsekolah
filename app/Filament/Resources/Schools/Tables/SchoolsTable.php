<?php

namespace App\Filament\Resources\Schools\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class SchoolsTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->label('Nama Sekolah')
                    ->searchable(),
                TextColumn::make('school_type')
                    ->label('Tipe')
                    ->badge()
                    ->searchable(),
                TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Kota / Kabupaten')
                    ->searchable(),
                TextColumn::make('province')
                    ->label('Provinsi')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('principal_name')
                    ->label('Kepala Sekolah')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
