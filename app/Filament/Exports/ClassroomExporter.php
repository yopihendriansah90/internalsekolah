<?php

namespace App\Filament\Exports;

use App\Models\Classroom;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ClassroomExporter extends Exporter
{
    protected static ?string $model = Classroom::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Kelas/Rombel'),
            ExportColumn::make('grade_level')
                ->label('Tingkat'),
            ExportColumn::make('major.short_name')
                ->label('Struktur Akademik'),
            ExportColumn::make('academicYear.name')
                ->label('Tahun Ajaran'),
            ExportColumn::make('homeroomTeacher.full_name')
                ->label('Wali Kelas'),
            ExportColumn::make('capacity')
                ->label('Kapasitas'),
            ExportColumn::make('is_active')
                ->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your classroom export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
