<?php

namespace App\Filament\Exports;

use App\Models\TeachingAssignment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class TeachingAssignmentExporter extends Exporter
{
    protected static ?string $model = TeachingAssignment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('teacherProfile.full_name')
                ->label('Nama Guru'),
            ExportColumn::make('subject.name')
                ->label('Mata Pelajaran'),
            ExportColumn::make('classroom.name')
                ->label('Kelas/Rombel'),
            ExportColumn::make('academicYear.name')
                ->label('Tahun Ajaran'),
            ExportColumn::make('semester.name')
                ->label('Semester'),
            ExportColumn::make('hours_per_week')
                ->label('JP per Minggu'),
            ExportColumn::make('assignment_status')
                ->label('Status Penugasan'),
            ExportColumn::make('start_date')
                ->label('Mulai'),
            ExportColumn::make('end_date')
                ->label('Selesai'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your teaching assignment export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
