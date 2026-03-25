<?php

namespace App\Support\Filament;

use Filament\Actions\ExportAction;

class ExportActionFactory
{
    public static function make(string $exporter, string $filePrefix): ExportAction
    {
        return ExportAction::make()
            ->label('Export Data')
            ->exporter($exporter)
            ->enableVisibleTableColumnsByDefault()
            ->fileName(fn (): string => "{$filePrefix}-".now()->format('Y-m-d'));
    }
}
