<?php

namespace App\Filament\Resources\StudentClassHistories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class StudentClassHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('studentProfile.full_name')
                    ->label('Siswa')
                    ->searchable(),
                TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('academicYear.name')
                    ->label('Tahun Ajaran')
                    ->searchable(),
                TextColumn::make('semester.name')
                    ->label('Semester')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('start_date')
                    ->label('Mulai')
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
