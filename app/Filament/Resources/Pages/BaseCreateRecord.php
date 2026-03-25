<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

abstract class BaseCreateRecord extends CreateRecord
{
    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return sprintf('%s berhasil dibuat.', static::getResource()::getTitleCaseModelLabel());
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
