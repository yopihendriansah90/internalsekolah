<?php

namespace App\Support\Filament;

use Filament\Schemas\Components\Section;

class AdminSection extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->iconColor('primary')
            ->compact()
            ->columnSpanFull();
    }
}
