<?php

namespace App\Filament\Exports;

use App\Models\Letter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class LetterExporter extends Exporter
{
    protected static ?string $model = Letter::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('letter_number')
                ->label('Nomor Surat'),
            ExportColumn::make('agenda_number')
                ->label('Nomor Agenda'),
            ExportColumn::make('category.name')
                ->label('Kategori'),
            ExportColumn::make('subject')
                ->label('Perihal'),
            ExportColumn::make('direction')
                ->label('Arah'),
            ExportColumn::make('letter_date')
                ->label('Tanggal Surat'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('sender_name')
                ->label('Pengirim'),
            ExportColumn::make('recipient_name')
                ->label('Penerima'),
            ExportColumn::make('signed_by_name')
                ->label('Ditandatangani Oleh'),
            ExportColumn::make('createdBy.name')
                ->label('Dibuat Oleh'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your letter export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
