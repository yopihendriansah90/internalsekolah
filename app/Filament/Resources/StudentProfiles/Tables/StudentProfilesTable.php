<?php

namespace App\Filament\Resources\StudentProfiles\Tables;

use App\Filament\Exports\StudentProfileExporter;
use App\Support\Filament\ExportActionFactory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class StudentProfilesTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('full_name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('major.short_name')
                    ->label('Struktur Akademik')
                    ->searchable(),
                TextColumn::make('entry_year')
                    ->label('Tahun Masuk')
                    ->numeric(),
                TextColumn::make('student_status')
                    ->label('Status')
                    ->badge(),
                IconColumn::make('is_alumni')
                    ->label('Alumni')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportActionFactory::make(StudentProfileExporter::class, 'data-siswa'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
