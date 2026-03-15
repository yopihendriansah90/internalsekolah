<?php

namespace App\Filament\Resources\TeachingAssignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class TeachingAssignmentsTable
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
                TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('academicYear.name')
                    ->label('Tahun Ajaran')
                    ->searchable(),
                TextColumn::make('semester.name')
                    ->label('Semester')
                    ->searchable(),
                TextColumn::make('hours_per_week')
                    ->label('JP/Minggu')
                    ->numeric(),
                TextColumn::make('assignment_status')
                    ->label('Status')
                    ->badge(),
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
