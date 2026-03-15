<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord;

abstract class BaseCreateRecord extends CreateRecord
{
    protected function getCreatedNotificationTitle(): ?string
    {
        return sprintf('%s berhasil dibuat.', static::getResource()::getTitleCaseModelLabel());
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
