<?php

namespace App\Filament\Resources\PpdbRegistrations\Pages;

use App\Filament\Resources\PpdbRegistrations\PpdbRegistrationResource;
use App\Filament\Resources\Pages\BaseCreateRecord;
use App\Models\PpdbRegistration;
use Illuminate\Database\QueryException;
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

        $data['registration_number'] = $this->generateRegistrationNumber(
            year: (int) date('Y', strtotime((string) ($data['registration_date'] ?? now()->toDateString()))),
        );

        return $data;
    }

    protected function handleRecordCreation(array $data): PpdbRegistration
    {
        $maxRetries = 5;

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                /** @var PpdbRegistration $record */
                $record = parent::handleRecordCreation($data);

                return $record;
            } catch (QueryException $exception) {
                if (! $this->isUniqueViolation($exception) || ($attempt === $maxRetries)) {
                    throw $exception;
                }

                $year = (int) date('Y', strtotime((string) ($data['registration_date'] ?? now()->toDateString())));
                $data['registration_number'] = $this->generateRegistrationNumber($year);
            }
        }

        throw ValidationException::withMessages([
            'data.registration_number' => 'Gagal membuat nomor pendaftaran otomatis. Silakan coba lagi.',
        ]);
    }

    protected function generateRegistrationNumber(int $year): string
    {
        $prefix = "PPDB-{$year}-";
        $maxSequence = 0;

        $numbers = PpdbRegistration::query()
            ->where('registration_number', 'like', "{$prefix}%")
            ->pluck('registration_number');

        foreach ($numbers as $number) {
            $value = (string) $number;

            if (preg_match('/^'.preg_quote($prefix, '/').'(\d{6})$/', $value, $matches) !== 1) {
                continue;
            }

            $sequence = (int) $matches[1];
            $maxSequence = max($maxSequence, $sequence);
        }

        $next = $maxSequence + 1;

        return sprintf('%s%06d', $prefix, $next);
    }

    protected function isUniqueViolation(QueryException $exception): bool
    {
        $sqlState = (string) ($exception->errorInfo[0] ?? '');

        return in_array($sqlState, ['23000', '23505'], true);
    }
}
