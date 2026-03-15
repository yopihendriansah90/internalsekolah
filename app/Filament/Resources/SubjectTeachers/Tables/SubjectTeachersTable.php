<?php

namespace App\Filament\Resources\SubjectTeachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class SubjectTeachersTable
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
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                TextColumn::make('academicYear.name')
                    ->label('Tahun Ajaran')
                    ->searchable(),
                TextColumn::make('competency_notes')
                    ->label('Catatan Kompetensi')
                    ->limit(40),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
