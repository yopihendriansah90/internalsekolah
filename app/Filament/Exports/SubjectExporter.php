<?php

namespace App\Filament\Exports;

use App\Models\Subject;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class SubjectExporter extends Exporter
{
    protected static ?string $model = Subject::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nama Mata Pelajaran'),
            ExportColumn::make('code')
                ->label('Kode'),
            ExportColumn::make('education_level')
                ->label('Jenjang'),
            ExportColumn::make('school_type_scope')
                ->label('Cakupan Tipe Sekolah'),
            ExportColumn::make('subject_group')
                ->label('Kelompok'),
            ExportColumn::make('major.short_name')
                ->label('Struktur Akademik'),
            ExportColumn::make('is_productive')
                ->label('Produktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your subject export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
