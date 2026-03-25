<?php

namespace App\Filament\Exports;

use App\Models\School;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class SchoolExporter extends Exporter
{
    protected static ?string $model = School::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name'),
            ExportColumn::make('school_type'),
            ExportColumn::make('npsn'),
            ExportColumn::make('address'),
            ExportColumn::make('village'),
            ExportColumn::make('district'),
            ExportColumn::make('city'),
            ExportColumn::make('province'),
            ExportColumn::make('postal_code'),
            ExportColumn::make('phone'),
            ExportColumn::make('email'),
            ExportColumn::make('website'),
            ExportColumn::make('principal_name'),
            ExportColumn::make('principal_nip'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your school export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
