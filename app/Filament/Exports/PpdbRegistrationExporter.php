<?php

namespace App\Filament\Exports;

use App\Models\PpdbRegistration;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PpdbRegistrationExporter extends Exporter
{
    protected static ?string $model = PpdbRegistration::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('registration_number')
                ->label('Nomor Pendaftaran'),
            ExportColumn::make('registration_date')
                ->label('Tanggal Pendaftaran'),
            ExportColumn::make('full_name')
                ->label('Nama Calon Siswa'),
            ExportColumn::make('origin_school')
                ->label('Asal Sekolah'),
            ExportColumn::make('entry_path')
                ->label('Jalur Masuk'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('documents_verified_at')
                ->label('Dokumen Terverifikasi'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your ppdb registration export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
