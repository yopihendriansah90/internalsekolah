<?php

namespace App\Filament\Exports;

use App\Models\LetterCategory;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class LetterCategoryExporter extends Exporter
{
    protected static ?string $model = LetterCategory::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Kategori'),
            ExportColumn::make('code')
                ->label('Kode'),
            ExportColumn::make('scope')
                ->label('Lingkup'),
            ExportColumn::make('is_active')
                ->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your letter category export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
