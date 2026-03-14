<?php

namespace Database\Seeders;

use App\Enums\SchoolTypeEnum;
use App\Enums\SubjectGroupEnum;
use App\Enums\SystemSettingKeyEnum;
use App\Models\AcademicYear;
use App\Models\AdditionalAssignment;
use App\Models\AlumniProfile;
use App\Models\Classroom;
use App\Models\Major;
use App\Models\Position;
use App\Models\PpdbRegistration;
use App\Models\School;
use App\Models\Semester;
use App\Models\StudentClassHistory;
use App\Models\StudentProfile;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\SystemSetting;
use App\Models\TeacherPosition;
use App\Models\TeacherProfile;
use App\Models\TeachingAssignment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::query()->updateOrCreate(
            ['email' => 'info@smkcontoh.sch.id'],
            [
                'name' => 'SMK Contoh Nusantara',
                'school_type' => SchoolTypeEnum::SMK,
                'npsn' => '12345678',
                'address' => 'Jl. Pendidikan No. 1',
                'village' => 'Suka Maju',
                'district' => 'Cibinong',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16911',
                'phone' => '0211234567',
                'website' => 'https://smkcontoh.sch.id',
                'principal_name' => 'Drs. Ahmad Rahman',
                'principal_nip' => '197812312005011001',
            ],
        );

        SystemSetting::putValue(SystemSettingKeyEnum::ActiveSchoolId, $school->id, 'integer');
        SystemSetting::putValue(SystemSettingKeyEnum::AppInitialized, true, 'boolean');

        $this->seedAcademicYears();
        $majors = $this->seedMajors();
        $this->seedPositions();
        $this->seedSubjects($majors);
        $this->seedUsers();
        $teachers = $this->seedTeacherProfiles();
        $classrooms = $this->seedClassrooms($majors, $teachers);
        $this->seedTeacherPositions($teachers);
        $this->seedSubjectTeachers($teachers);
        $this->seedTeachingAssignments($teachers, $classrooms);
        $this->seedAdditionalAssignments($teachers, $classrooms);
        $students = $this->seedStudentProfiles($majors);
        $this->seedPpdbRegistrations($students);
        $this->seedStudentClassHistories($students, $classrooms);
        $this->seedAlumniProfiles($students);
    }

    protected function seedAcademicYears(): void
    {
        foreach (range(0, 4) as $offset) {
            $startYear = (int) now()->format('Y') - 2 + $offset;
            $endYear = $startYear + 1;

            $academicYear = AcademicYear::query()->updateOrCreate(
                ['name' => "{$startYear}/{$endYear}"],
                [
                    'start_date' => "{$startYear}-07-01",
                    'end_date' => "{$endYear}-06-30",
                    'is_active' => $offset === 2,
                ],
            );

            Semester::query()->updateOrCreate(
                ['academic_year_id' => $academicYear->id, 'code' => 'GANJIL'],
                ['name' => 'Semester Ganjil', 'is_active' => $offset === 2],
            );

            Semester::query()->updateOrCreate(
                ['academic_year_id' => $academicYear->id, 'code' => 'GENAP'],
                ['name' => 'Semester Genap', 'is_active' => false],
            );
        }
    }

    protected function seedMajors(): Collection
    {
        $majors = [
            ['name' => 'Rekayasa Perangkat Lunak', 'code' => 'RPL', 'short_name' => 'RPL'],
            ['name' => 'Teknik Komputer dan Jaringan', 'code' => 'TKJ', 'short_name' => 'TKJ'],
            ['name' => 'Akuntansi', 'code' => 'AKL', 'short_name' => 'AKL'],
            ['name' => 'Desain Komunikasi Visual', 'code' => 'DKV', 'short_name' => 'DKV'],
            ['name' => 'Manajemen Perkantoran', 'code' => 'MPLB', 'short_name' => 'MPLB'],
            ['name' => 'Bisnis Daring dan Pemasaran', 'code' => 'BDP', 'short_name' => 'BDP'],
            ['name' => 'Teknik Kendaraan Ringan', 'code' => 'TKR', 'short_name' => 'TKR'],
            ['name' => 'Teknik Sepeda Motor', 'code' => 'TSM', 'short_name' => 'TSM'],
            ['name' => 'Perhotelan', 'code' => 'PH', 'short_name' => 'PH'],
            ['name' => 'Kuliner', 'code' => 'KLN', 'short_name' => 'KLN'],
        ];

        return collect($majors)->map(function (array $major, int $index): Major {
            return Major::query()->updateOrCreate(
                ['code' => $major['code']],
                [
                    'name' => $major['name'],
                    'short_name' => $major['short_name'],
                    'department_group' => $index < 5 ? 'Bisnis dan Teknologi' : 'Keahlian Praktik',
                    'description' => 'Data dummy jurusan/program keahlian untuk testing.',
                    'is_active' => true,
                ],
            );
        });
    }

    protected function seedPositions(): void
    {
        $positions = [
            ['name' => 'Kepala Sekolah', 'code' => 'KEPSEK', 'type' => 'struktural'],
            ['name' => 'Wakil Kepala Sekolah', 'code' => 'WAKASEK', 'type' => 'struktural'],
            ['name' => 'Guru Mata Pelajaran', 'code' => 'GMP', 'type' => 'fungsional'],
            ['name' => 'Wali Kelas', 'code' => 'WALAS', 'type' => 'tugas_tambahan'],
            ['name' => 'Kepala Program Keahlian', 'code' => 'KAPROG', 'type' => 'struktural'],
            ['name' => 'Staf Tata Usaha', 'code' => 'TU', 'type' => 'administratif'],
            ['name' => 'Operator Sekolah', 'code' => 'OPS', 'type' => 'administratif'],
            ['name' => 'Pembina OSIS', 'code' => 'OSIS', 'type' => 'tugas_tambahan'],
            ['name' => 'Koordinator PKL', 'code' => 'PKL', 'type' => 'tugas_tambahan'],
            ['name' => 'Pustakawan', 'code' => 'PUSTAKA', 'type' => 'administratif'],
        ];

        foreach ($positions as $position) {
            Position::query()->updateOrCreate(
                ['code' => $position['code']],
                [
                    'name' => $position['name'],
                    'type' => $position['type'],
                    'description' => 'Data dummy jabatan untuk testing.',
                ],
            );
        }
    }

    protected function seedSubjects(Collection $majors): void
    {
        $subjects = [
            ['name' => 'Matematika', 'code' => 'MAT001', 'group' => SubjectGroupEnum::Umum, 'major' => null, 'productive' => false],
            ['name' => 'Bahasa Indonesia', 'code' => 'BIN001', 'group' => SubjectGroupEnum::Umum, 'major' => null, 'productive' => false],
            ['name' => 'Bahasa Inggris', 'code' => 'BIG001', 'group' => SubjectGroupEnum::Umum, 'major' => null, 'productive' => false],
            ['name' => 'Informatika', 'code' => 'INF001', 'group' => SubjectGroupEnum::Umum, 'major' => null, 'productive' => false],
            ['name' => 'Pemrograman Web', 'code' => 'RPL101', 'group' => SubjectGroupEnum::Kejuruan, 'major' => 'RPL', 'productive' => true],
            ['name' => 'Administrasi Sistem Jaringan', 'code' => 'TKJ101', 'group' => SubjectGroupEnum::Kejuruan, 'major' => 'TKJ', 'productive' => true],
            ['name' => 'Akuntansi Dasar', 'code' => 'AKL101', 'group' => SubjectGroupEnum::Kejuruan, 'major' => 'AKL', 'productive' => true],
            ['name' => 'Desain Grafis', 'code' => 'DKV101', 'group' => SubjectGroupEnum::Kejuruan, 'major' => 'DKV', 'productive' => true],
            ['name' => 'Produk Kreatif dan Kewirausahaan', 'code' => 'PKK001', 'group' => SubjectGroupEnum::Peminatan, 'major' => null, 'productive' => false],
            ['name' => 'Muatan Lokal', 'code' => 'MUL001', 'group' => SubjectGroupEnum::MuatanLokal, 'major' => null, 'productive' => false],
        ];

        foreach ($subjects as $subject) {
            $major = $subject['major']
                ? $majors->firstWhere('code', $subject['major'])
                : null;

            Subject::query()->updateOrCreate(
                ['code' => $subject['code']],
                [
                    'name' => $subject['name'],
                    'education_level' => 'SMA/SMK',
                    'school_type_scope' => $subject['major'] ? 'SMK' : 'ALL',
                    'subject_group' => $subject['group'],
                    'major_id' => $major?->id,
                    'is_productive' => $subject['productive'],
                    'description' => 'Data dummy mata pelajaran untuk testing.',
                ],
            );
        }
    }

    protected function seedUsers(): void
    {
        $roles = Role::query()->pluck('id', 'name');

        foreach (range(1, 10) as $index) {
            $user = User::query()->updateOrCreate(
                ['email' => "user{$index}@mail.com"],
                [
                    'name' => "User Dummy {$index}",
                    'username' => "dummy{$index}",
                    'password' => Hash::make('password'),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
            );

            $roleName = match (true) {
                $index <= 2 => 'Admin',
                $index <= 4 => 'Operator Guru',
                $index <= 6 => 'Operator Siswa',
                $index <= 8 => 'Tata Usaha',
                default => 'Kepala Sekolah',
            };

            if ($roles->has($roleName)) {
                $user->syncRoles([$roleName]);
            }
        }
    }

    protected function seedTeacherProfiles(): Collection
    {
        $users = User::query()
            ->where('email', '!=', 'admin@mail.com')
            ->orderBy('id')
            ->take(10)
            ->get();

        return $users->values()->map(function (User $user, int $index): TeacherProfile {
            return TeacherProfile::query()->updateOrCreate(
                ['employee_number' => 'EMP'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT)],
                [
                    'user_id' => $user->id,
                    'nip' => '19850'.str_pad((string) ($index + 1), 13, '0', STR_PAD_LEFT),
                    'nuptk' => '20260'.str_pad((string) ($index + 1), 11, '0', STR_PAD_LEFT),
                    'dapodik_id' => 'DAPODIK-GURU-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'full_name' => 'Guru Dummy '.($index + 1),
                    'birth_place' => 'Bogor',
                    'birth_date' => now()->subYears(28 + $index)->subDays($index)->toDateString(),
                    'gender' => $index % 2 === 0 ? 'L' : 'P',
                    'religion' => 'Islam',
                    'phone' => '081200000'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'email' => "guru{$index}@mail.com",
                    'address' => 'Alamat dummy guru untuk testing modul guru.',
                    'education_last' => $index < 5 ? 'S1 Pendidikan' : 'S1 Teknik Informatika',
                    'employment_status' => $index < 6 ? 'tetap' : 'honorer',
                    'teacher_status' => $index < 4 ? 'guru_mapel' : 'produktif',
                    'join_date' => now()->subYears(5)->addMonths($index)->toDateString(),
                    'is_active' => true,
                    'notes' => 'Data dummy guru untuk pengujian modul guru.',
                ],
            );
        });
    }

    protected function seedClassrooms(Collection $majors, Collection $teachers): Collection
    {
        $academicYear = AcademicYear::query()->where('is_active', true)->firstOrFail();

        $classrooms = [
            ['name' => 'X-RPL-1', 'grade_level' => 'X', 'major' => 'RPL'],
            ['name' => 'X-TKJ-1', 'grade_level' => 'X', 'major' => 'TKJ'],
            ['name' => 'X-AKL-1', 'grade_level' => 'X', 'major' => 'AKL'],
            ['name' => 'X-DKV-1', 'grade_level' => 'X', 'major' => 'DKV'],
            ['name' => 'XI-RPL-1', 'grade_level' => 'XI', 'major' => 'RPL'],
            ['name' => 'XI-TKJ-1', 'grade_level' => 'XI', 'major' => 'TKJ'],
            ['name' => 'XI-AKL-1', 'grade_level' => 'XI', 'major' => 'AKL'],
            ['name' => 'XI-DKV-1', 'grade_level' => 'XI', 'major' => 'DKV'],
            ['name' => 'XII-RPL-1', 'grade_level' => 'XII', 'major' => 'RPL'],
            ['name' => 'XII-TKJ-1', 'grade_level' => 'XII', 'major' => 'TKJ'],
        ];

        return collect($classrooms)->map(function (array $classroom, int $index) use ($academicYear, $majors, $teachers): Classroom {
            $major = $majors->firstWhere('code', $classroom['major']);
            $homeroomTeacher = $teachers->get($index);

            return Classroom::query()->updateOrCreate(
                ['academic_year_id' => $academicYear->id, 'name' => $classroom['name']],
                [
                    'major_id' => $major?->id,
                    'grade_level' => $classroom['grade_level'],
                    'capacity' => 36,
                    'homeroom_teacher_id' => $homeroomTeacher?->id,
                    'is_active' => true,
                    'notes' => 'Data dummy kelas untuk pengujian penugasan guru.',
                ],
            );
        });
    }

    protected function seedTeacherPositions(Collection $teachers): void
    {
        $positionMap = [
            'Kepala Sekolah',
            'Wakil Kepala Sekolah',
            'Guru Mata Pelajaran',
            'Wali Kelas',
            'Kepala Program Keahlian',
            'Guru Mata Pelajaran',
            'Guru Mata Pelajaran',
            'Pembina OSIS',
            'Koordinator PKL',
            'Guru Mata Pelajaran',
        ];

        foreach ($teachers as $index => $teacher) {
            $position = Position::query()->where('name', $positionMap[$index] ?? 'Guru Mata Pelajaran')->first();

            if (! $position) {
                continue;
            }

            TeacherPosition::query()->updateOrCreate(
                [
                    'teacher_profile_id' => $teacher->id,
                    'position_id' => $position->id,
                ],
                [
                    'start_date' => now()->subYears(2)->addMonths($index)->toDateString(),
                    'end_date' => null,
                    'is_active' => true,
                    'decree_number' => 'SK-GURU-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'notes' => 'Data dummy penempatan jabatan guru.',
                ],
            );
        }
    }

    protected function seedSubjectTeachers(Collection $teachers): void
    {
        $academicYear = AcademicYear::query()->where('is_active', true)->firstOrFail();
        $subjects = Subject::query()->orderBy('id')->get()->values();

        foreach ($teachers as $index => $teacher) {
            $subject = $subjects->get($index % max($subjects->count(), 1));

            if (! $subject) {
                continue;
            }

            SubjectTeacher::query()->updateOrCreate(
                [
                    'teacher_profile_id' => $teacher->id,
                    'subject_id' => $subject->id,
                    'academic_year_id' => $academicYear->id,
                ],
                [
                    'competency_notes' => 'Guru memiliki kompetensi mengampu mata pelajaran '.$subject->name.'.',
                    'notes' => 'Data dummy kompetensi guru mapel.',
                ],
            );
        }
    }

    protected function seedTeachingAssignments(Collection $teachers, Collection $classrooms): void
    {
        $academicYear = AcademicYear::query()->where('is_active', true)->firstOrFail();
        $semester = Semester::query()->where('is_active', true)->first();
        $subjectTeachers = SubjectTeacher::query()->with('subject')->orderBy('id')->get()->values();

        foreach ($teachers as $index => $teacher) {
            $subjectTeacher = $subjectTeachers->get($index % max($subjectTeachers->count(), 1));
            $classroom = $classrooms->get($index % max($classrooms->count(), 1));

            if (! $subjectTeacher || ! $classroom) {
                continue;
            }

            TeachingAssignment::query()->updateOrCreate(
                [
                    'teacher_profile_id' => $teacher->id,
                    'subject_id' => $subjectTeacher->subject_id,
                    'classroom_id' => $classroom->id,
                    'academic_year_id' => $academicYear->id,
                ],
                [
                    'semester_id' => $semester?->id,
                    'hours_per_week' => 4 + ($index % 3),
                    'assignment_status' => 'aktif',
                    'start_date' => now()->startOfYear()->toDateString(),
                    'end_date' => null,
                    'notes' => 'Data dummy penugasan mengajar.',
                ],
            );
        }
    }

    protected function seedAdditionalAssignments(Collection $teachers, Collection $classrooms): void
    {
        foreach ($teachers->take(4) as $index => $teacher) {
            AdditionalAssignment::query()->updateOrCreate(
                [
                    'teacher_profile_id' => $teacher->id,
                    'assignment_type' => $index === 0 ? 'wali_kelas' : 'koordinator',
                ],
                [
                    'classroom_id' => $classrooms->get($index)?->id,
                    'start_date' => now()->startOfYear()->toDateString(),
                    'end_date' => null,
                    'is_active' => true,
                    'notes' => 'Data dummy tugas tambahan guru.',
                ],
            );
        }
    }

    protected function seedStudentProfiles(Collection $majors): Collection
    {
        return collect(range(1, 10))->map(function (int $index) use ($majors): StudentProfile {
            $major = $majors->get(($index - 1) % max($majors->count(), 1));
            $isAlumni = $index >= 9;
            $entryYear = (int) now()->format('Y') - ($isAlumni ? 4 : 2);

            return StudentProfile::query()->updateOrCreate(
                ['nis' => 'SIS'.str_pad((string) $index, 4, '0', STR_PAD_LEFT)],
                [
                    'nisn' => '00555'.str_pad((string) $index, 5, '0', STR_PAD_LEFT),
                    'dapodik_id' => 'DAPODIK-SISWA-'.str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                    'registration_number' => 'PPDB-2026-'.str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                    'major_id' => $major?->id,
                    'full_name' => 'Siswa Dummy '.$index,
                    'birth_place' => 'Bogor',
                    'birth_date' => now()->subYears(15 + $index)->subDays($index)->toDateString(),
                    'gender' => $index % 2 === 0 ? 'P' : 'L',
                    'religion' => 'Islam',
                    'phone' => '081300000'.str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                    'email' => "siswa{$index}@mail.com",
                    'address' => 'Alamat dummy siswa untuk pengujian modul siswa.',
                    'guardian_name' => 'Wali Siswa '.$index,
                    'guardian_phone' => '082100000'.str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                    'entry_year' => $entryYear,
                    'student_status' => $isAlumni ? 'lulus' : 'aktif',
                    'ppdb_status' => 'diterima',
                    'graduation_year' => $isAlumni ? $entryYear + 3 : null,
                    'is_alumni' => $isAlumni,
                    'notes' => 'Data dummy siswa untuk pengujian modul siswa.',
                ],
            );
        });
    }

    protected function seedPpdbRegistrations(Collection $students): void
    {
        foreach ($students as $index => $student) {
            PpdbRegistration::query()->updateOrCreate(
                ['student_profile_id' => $student->id],
                [
                    'registration_number' => $student->registration_number,
                    'registration_date' => now()->subMonths(10)->addDays($index)->toDateString(),
                    'origin_school' => 'SMP Dummy '.($index + 1),
                    'entry_path' => $index % 2 === 0 ? 'reguler' : 'prestasi',
                    'status' => 'diterima',
                    'documents_verified_at' => now()->subMonths(9)->addDays($index),
                    'notes' => 'Data dummy PPDB siswa.',
                ],
            );
        }
    }

    protected function seedStudentClassHistories(Collection $students, Collection $classrooms): void
    {
        $academicYear = AcademicYear::query()->where('is_active', true)->firstOrFail();
        $semester = Semester::query()->where('is_active', true)->first();

        foreach ($students as $index => $student) {
            $classroom = $classrooms->get($index % max($classrooms->count(), 1));

            if (! $classroom) {
                continue;
            }

            StudentClassHistory::query()->updateOrCreate(
                [
                    'student_profile_id' => $student->id,
                    'classroom_id' => $classroom->id,
                    'academic_year_id' => $academicYear->id,
                ],
                [
                    'semester_id' => $semester?->id,
                    'start_date' => now()->startOfYear()->toDateString(),
                    'end_date' => $student->is_alumni ? now()->endOfYear()->toDateString() : null,
                    'status' => $student->is_alumni ? 'lulus' : 'aktif',
                    'notes' => 'Data dummy riwayat kelas siswa.',
                ],
            );
        }
    }

    protected function seedAlumniProfiles(Collection $students): void
    {
        foreach ($students->filter(fn (StudentProfile $student): bool => $student->is_alumni) as $index => $student) {
            AlumniProfile::query()->updateOrCreate(
                ['student_profile_id' => $student->id],
                [
                    'graduation_year' => $student->graduation_year,
                    'certificate_number' => 'IJZ-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'destination_after_graduation' => $index % 2 === 0 ? 'Bekerja' : 'Kuliah',
                    'notes' => 'Data dummy alumni siswa.',
                ],
            );
        }
    }
}
