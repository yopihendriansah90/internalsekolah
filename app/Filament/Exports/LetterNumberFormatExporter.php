<?php

namespace App\Filament\Exports;

use App\Models\LetterNumberFormat;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class LetterNumberFormatExporter extends Exporter
{
    protected static ?string $model = LetterNumberFormat::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nama Format'),
            ExportColumn::make('code')
                ->label('Kode'),
            ExportColumn::make('category.name')
                ->label('Kategori'),
            ExportColumn::make('format_pattern')
                ->label('Pola'),
            ExportColumn::make('sequence_reset_period')
                ->label('Reset'),
            ExportColumn::make('current_sequence')
                ->label('No. Berjalan'),
            ExportColumn::make('is_active')
                ->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your letter number format export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
