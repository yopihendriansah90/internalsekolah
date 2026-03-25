<?php

namespace App\Filament\Exports;

use App\Models\LetterTemplate;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class LetterTemplateExporter extends Exporter
{
    protected static ?string $model = LetterTemplate::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Template'),
            ExportColumn::make('code')
                ->label('Kode'),
            ExportColumn::make('category.name')
                ->label('Kategori'),
            ExportColumn::make('subject_template')
                ->label('Perihal Template'),
            ExportColumn::make('is_active')
                ->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your letter template export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
