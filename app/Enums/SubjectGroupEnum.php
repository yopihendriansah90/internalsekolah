<?php

namespace App\Enums;

enum SubjectGroupEnum: string
{
    case Umum = 'umum';
    case Peminatan = 'peminatan';
    case Kejuruan = 'kejuruan';
    case MuatanLokal = 'muatan_lokal';

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
        return match ($this) {
            self::Umum => 'Umum',
            self::Peminatan => 'Peminatan',
            self::Kejuruan => 'Kejuruan',
            self::MuatanLokal => 'Muatan Lokal',
        };
    }
}
