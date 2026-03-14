<?php

namespace App\Services\School;

class AcademicLabelService
{
    public function structureLabel(?string $schoolType): string
    {
        return match ($schoolType) {
            'SMK' => 'Program Keahlian',
            'SMA' => 'Jurusan',
            default => 'Struktur Akademik',
        };
    }
}
