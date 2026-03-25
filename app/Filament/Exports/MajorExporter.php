<?php

namespace App\Filament\Exports;

use App\Models\Major;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MajorExporter extends Exporter
{
    protected static ?string $model = Major::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nama Struktur Akademik'),
            ExportColumn::make('code')
                ->label('Kode'),
            ExportColumn::make('short_name')
                ->label('Singkatan'),
            ExportColumn::make('education_level')
                ->label('Jenjang'),
            ExportColumn::make('major_type')
                ->label('Tipe'),
            ExportColumn::make('department_group')
                ->label('Kelompok'),
            ExportColumn::make('is_active')
                ->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your major export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
