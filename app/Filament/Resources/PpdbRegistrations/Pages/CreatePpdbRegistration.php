<?php

namespace App\Filament\Resources\PpdbRegistrations\Pages;

use App\Filament\Resources\PpdbRegistrations\PpdbRegistrationResource;
use App\Filament\Resources\Pages\BaseCreateRecord;
use Illuminate\Validation\ValidationException;

class CreatePpdbRegistration extends BaseCreateRecord
{
    protected static string $resource = PpdbRegistrationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['status'] ?? null) === 'diterima') {
            throw ValidationException::withMessages([
                'data.status' => 'Simpan pendaftar terlebih dahulu, lalu gunakan aksi "Terima Sebagai Siswa".',
            ]);
        }

        return $data;
    }
}
