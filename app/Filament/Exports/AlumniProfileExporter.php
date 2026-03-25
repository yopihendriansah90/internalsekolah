<?php

namespace App\Filament\Exports;

use App\Models\AlumniProfile;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class AlumniProfileExporter extends Exporter
{
    protected static ?string $model = AlumniProfile::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('studentProfile.full_name')
                ->label('Nama Alumni'),
            ExportColumn::make('studentProfile.nis')
                ->label('NIS'),
            ExportColumn::make('studentProfile.major.short_name')
                ->label('Struktur Akademik'),
            ExportColumn::make('graduation_year')
                ->label('Tahun Lulus'),
            ExportColumn::make('certificate_number')
                ->label('Nomor Ijazah'),
            ExportColumn::make('destination_after_graduation')
                ->label('Tujuan Setelah Lulus'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your alumni profile export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
