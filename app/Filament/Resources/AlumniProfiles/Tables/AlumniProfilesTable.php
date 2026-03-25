<?php

namespace App\Filament\Resources\AlumniProfiles\Tables;

use App\Filament\Exports\AlumniProfileExporter;
use App\Support\Filament\ExportActionFactory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use App\Support\Filament\AdminTable;
use Filament\Tables\Table;

class AlumniProfilesTable
{
    public static function configure(Table $table): Table
    {
        return AdminTable::configure($table)
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('studentProfile.full_name')
                    ->label('Nama Alumni')
                    ->searchable(),
                TextColumn::make('graduation_year')
                    ->label('Tahun Lulus')
                    ->numeric(),
                TextColumn::make('certificate_number')
                    ->label('Nomor Ijazah')
                    ->searchable(),
                TextColumn::make('destination_after_graduation')
                    ->label('Tujuan Lanjut')
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportActionFactory::make(AlumniProfileExporter::class, 'alumni'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
