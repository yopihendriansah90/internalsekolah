<?php

namespace App\Support\Filament;

use Filament\Tables\Table;

class AdminTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(10)
            ->persistSearchInSession()
            ->persistSortInSession()
            ->searchDebounce('700ms')
            ->searchPlaceholder('Cari data penting...');
    }
}
