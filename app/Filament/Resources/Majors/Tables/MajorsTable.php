<?php

namespace App\Filament\Resources\Majors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class MajorsTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('short_name')
                    ->label('Singkatan')
                    ->searchable(),
                TextColumn::make('education_level')
                    ->label('Jenjang')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'SMK' ? 'warning' : 'info'),
                TextColumn::make('major_type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'jurusan' => 'Jurusan',
                        'peminatan' => 'Peminatan',
                        'umum' => 'Umum',
                        default => $state,
                    }),
                TextColumn::make('department_group')
                    ->label('Kelompok')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
