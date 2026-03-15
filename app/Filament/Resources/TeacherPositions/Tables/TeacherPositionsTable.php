<?php

namespace App\Filament\Resources\TeacherPositions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class TeacherPositionsTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('teacherProfile.full_name')
                    ->label('Guru')
                    ->searchable(),
                TextColumn::make('position.name')
                    ->label('Jabatan')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y'),
                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y'),
                TextColumn::make('decree_number')
                    ->label('Nomor SK')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
