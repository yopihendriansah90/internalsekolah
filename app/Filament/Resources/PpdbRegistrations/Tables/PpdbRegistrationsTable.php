<?php

namespace App\Filament\Resources\PpdbRegistrations\Tables;

use App\Filament\Exports\PpdbRegistrationExporter;
use App\Filament\Resources\PpdbRegistrations\PpdbRegistrationResource;
use App\Support\Filament\ExportActionFactory;
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
                TextColumn::make('full_name')
                    ->label('Calon Siswa')
                    ->searchable(),
                TextColumn::make('major.short_name')
                    ->label('Pilihan')
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
                PpdbRegistrationResource::getAdmitStudentAction(),
                PpdbRegistrationResource::getOpenStudentAction(),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportActionFactory::make(PpdbRegistrationExporter::class, 'ppdb'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
