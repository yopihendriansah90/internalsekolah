<?php

namespace App\Filament\Exports;

use App\Models\TeacherProfile;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class TeacherProfileExporter extends Exporter
{
    protected static ?string $model = TeacherProfile::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('full_name')
                ->label('Nama Guru'),
            ExportColumn::make('employee_number')
                ->label('NIP Pegawai'),
            ExportColumn::make('nip')
                ->label('NIP'),
            ExportColumn::make('nuptk')
                ->label('NUPTK'),
            ExportColumn::make('gender')
                ->label('Jenis Kelamin'),
            ExportColumn::make('phone')
                ->label('Telepon'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('employment_status')
                ->label('Status Kepegawaian'),
            ExportColumn::make('teacher_status')
                ->label('Status Guru'),
            ExportColumn::make('join_date')
                ->label('Tanggal Bergabung'),
            ExportColumn::make('is_active')
                ->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your teacher profile export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
