<?php

namespace App\Services\School;

use App\Enums\SystemSettingKeyEnum;
use App\Models\School;
use App\Models\SystemSetting;

class SchoolContextService
{
    protected ?School $cachedSchool = null;

    public function current(): ?School
    {
        if ($this->cachedSchool instanceof School) {
            return $this->cachedSchool;
        }

        $schoolId = SystemSetting::getValue(SystemSettingKeyEnum::ActiveSchoolId);

        if (! is_numeric($schoolId)) {
            return null;
        }

        return $this->cachedSchool = School::query()->find((int) $schoolId);
    }

    public function hasActiveSchool(): bool
    {
        return $this->current() instanceof School;
    }

    public function schoolType(): ?string
    {
        return $this->current()?->school_type?->value;
    }

    public function isInitialized(): bool
    {
        return (bool) SystemSetting::getValue(SystemSettingKeyEnum::AppInitialized, false);
    }
}
