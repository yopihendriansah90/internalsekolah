<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\EditRecord;

abstract class BaseEditRecord extends EditRecord
{
    protected function getSavedNotificationTitle(): ?string
    {
        return sprintf('%s berhasil diperbarui.', static::getResource()::getTitleCaseModelLabel());
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
