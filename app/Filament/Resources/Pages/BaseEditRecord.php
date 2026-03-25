<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

abstract class BaseEditRecord extends EditRecord
{
    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return sprintf('%s berhasil diperbarui.', static::getResource()::getTitleCaseModelLabel());
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
