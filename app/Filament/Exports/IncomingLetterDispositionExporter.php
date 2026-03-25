<?php

namespace App\Filament\Exports;

use App\Models\IncomingLetterDisposition;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class IncomingLetterDispositionExporter extends Exporter
{
    protected static ?string $model = IncomingLetterDisposition::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('letter.letter_number')
                ->label('Nomor Surat'),
            ExportColumn::make('fromUser.name')
                ->label('Dari'),
            ExportColumn::make('toUser.name')
                ->label('Ke'),
            ExportColumn::make('instruction')
                ->label('Instruksi'),
            ExportColumn::make('due_date')
                ->label('Batas Waktu'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('read_at')
                ->label('Dibaca'),
            ExportColumn::make('completed_at')
                ->label('Selesai'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your incoming letter disposition export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
