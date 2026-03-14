<?php

namespace App\Enums;

enum SchoolTypeEnum: string
{
    case SMA = 'SMA';
    case SMK = 'SMK';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case): array => [$case->value => $case->label()])
            ->all();
    }

    public function label(): string
    {
        return $this->value;
    }
}
