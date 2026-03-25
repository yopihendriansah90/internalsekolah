<?php

namespace App\Filament\Exports;

use App\Models\StudentProfile;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class StudentProfileExporter extends Exporter
{
    protected static ?string $model = StudentProfile::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('full_name')
                ->label('Nama Siswa'),
            ExportColumn::make('nis')
                ->label('NIS'),
            ExportColumn::make('nisn')
                ->label('NISN'),
            ExportColumn::make('registration_number')
                ->label('Nomor Registrasi'),
            ExportColumn::make('major.short_name')
                ->label('Struktur Akademik'),
            ExportColumn::make('gender')
                ->label('Jenis Kelamin'),
            ExportColumn::make('phone')
                ->label('Telepon'),
            ExportColumn::make('guardian_name')
                ->label('Nama Wali'),
            ExportColumn::make('guardian_phone')
                ->label('Telepon Wali'),
            ExportColumn::make('entry_year')
                ->label('Tahun Masuk'),
            ExportColumn::make('student_status')
                ->label('Status Siswa'),
            ExportColumn::make('is_alumni')
                ->label('Alumni'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student profile export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
