<?php

namespace App\Services\Admissions;

use App\Models\PpdbRegistration;
use App\Models\StudentProfile;
use Illuminate\Validation\ValidationException;

class PpdbAdmissionService
{
    public function admit(PpdbRegistration $registration, array $data): StudentProfile
    {
        if ($registration->studentProfile) {
            return $registration->studentProfile;
        }

        $nis = $data['nis'] ?? null;

        if (blank($nis)) {
            throw ValidationException::withMessages([
                'nis' => 'NIS wajib diisi untuk menerima calon siswa.',
            ]);
        }

        $student = StudentProfile::query()->create([
            'nis' => $nis,
            'nisn' => $registration->nisn,
            'registration_number' => $registration->registration_number,
            'major_id' => $data['major_id'] ?? $registration->major_id,
            'full_name' => $registration->full_name,
            'birth_place' => $registration->birth_place,
            'birth_date' => $registration->birth_date,
            'gender' => $registration->gender,
            'religion' => $registration->religion,
            'phone' => $registration->phone,
            'email' => $registration->email,
            'address' => $registration->address,
            'guardian_name' => $registration->guardian_name,
            'guardian_phone' => $registration->guardian_phone,
            'entry_year' => $data['entry_year'] ?? (int) now()->format('Y'),
            'student_status' => 'aktif',
            'ppdb_status' => 'diterima',
            'is_alumni' => false,
            'notes' => $registration->notes,
        ]);

        $registration->forceFill([
            'student_profile_id' => $student->getKey(),
            'major_id' => $student->major_id,
            'status' => 'diterima',
        ])->save();

        return $student;
    }
}
