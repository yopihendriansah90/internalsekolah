<?php

namespace App\Services\School;

use App\Models\School;

class SchoolContextService
{
    protected ?School $cachedSchool = null;

    public function current(): ?School
    {
        if ($this->cachedSchool instanceof School) {
            return $this->cachedSchool;
        }

        return $this->cachedSchool = School::query()->first();
    }

    public function hasSchool(): bool
    {
        return $this->current() instanceof School;
    }

    public function schoolType(): ?string
    {
        return $this->current()?->school_type?->value;
    }

    public function isInitialized(): bool
    {
        return $this->hasSchool();
    }
}
