<?php

namespace App\Services\Sync;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Major;
use App\Models\Semester;
use App\Models\StudentClassHistory;
use App\Models\StudentProfile;
use App\Models\Subject;
use App\Models\TeacherProfile;
use App\Models\TeachingAssignment;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class MasterDataSyncPayloadFactory
{
    /**
     * @return list<string>
     */
    public function supportedEntities(): array
    {
        return [
            'academic_year',
            'semester',
            'major',
            'subject',
            'classroom',
            'teacher',
            'student',
            'student_class_membership',
            'teaching_assignment',
        ];
    }

    public function modelClassFor(string $entity): string
    {
        return match ($entity) {
            'academic_year' => AcademicYear::class,
            'semester' => Semester::class,
            'major' => Major::class,
            'subject' => Subject::class,
            'classroom' => Classroom::class,
            'teacher' => TeacherProfile::class,
            'student' => StudentProfile::class,
            'student_class_membership' => StudentClassHistory::class,
            'teaching_assignment' => TeachingAssignment::class,
            default => throw new InvalidArgumentException("Entity {$entity} tidak didukung."),
        };
    }

    public function payloadFor(string $entity, Model $model): array
    {
        return match ($entity) {
            'academic_year' => $this->academicYearPayload($model),
            'semester' => $this->semesterPayload($model),
            'major' => $this->majorPayload($model),
            'subject' => $this->subjectPayload($model),
            'classroom' => $this->classroomPayload($model),
            'teacher' => $this->teacherPayload($model),
            'student' => $this->studentPayload($model),
            'student_class_membership' => $this->studentClassMembershipPayload($model),
            'teaching_assignment' => $this->teachingAssignmentPayload($model),
            default => throw new InvalidArgumentException("Entity {$entity} tidak didukung."),
        };
    }

    public function operationFor(string $entity, Model $model): string
    {
        if (method_exists($model, 'trashed') && $model->trashed()) {
            return 'deactivate';
        }

        return match ($entity) {
            'academic_year' => $model->is_active ? 'upsert' : 'deactivate',
            'semester' => $model->is_active ? 'upsert' : 'deactivate',
            'major' => $model->is_active ? 'upsert' : 'deactivate',
            'subject' => 'upsert',
            'classroom' => $model->is_active ? 'upsert' : 'deactivate',
            'teacher' => $model->is_active ? 'upsert' : 'deactivate',
            'student' => (! $model->is_alumni && $model->student_status === 'aktif') ? 'upsert' : 'deactivate',
            'student_class_membership' => $this->isStudentClassMembershipActive($model) ? 'upsert' : 'deactivate',
            'teaching_assignment' => $this->isTeachingAssignmentActive($model) ? 'upsert' : 'deactivate',
            default => 'upsert',
        };
    }

    private function academicYearPayload(Model $model): array
    {
        /** @var AcademicYear $model */
        return [
            'name' => $model->name,
            'start_date' => optional($model->start_date)->toDateString(),
            'end_date' => optional($model->end_date)->toDateString(),
            'is_active' => (bool) $model->is_active,
        ];
    }

    private function semesterPayload(Model $model): array
    {
        /** @var Semester $model */
        return [
            'academic_year_source_id' => (string) $model->academic_year_id,
            'name' => $model->name,
            'code' => $model->code,
            'is_active' => (bool) $model->is_active,
        ];
    }

    private function majorPayload(Model $model): array
    {
        /** @var Major $model */
        return [
            'name' => $model->name,
            'code' => $model->code,
            'short_name' => $model->short_name,
            'education_level' => $model->education_level,
            'major_type' => $model->major_type,
            'is_active' => (bool) $model->is_active,
        ];
    }

    private function subjectPayload(Model $model): array
    {
        /** @var Subject $model */
        return [
            'name' => $model->name,
            'code' => $model->code,
            'major_source_id' => $model->major_id ? (string) $model->major_id : null,
            'education_level' => $model->education_level,
            'description' => $model->description,
            'is_active' => true,
        ];
    }

    private function classroomPayload(Model $model): array
    {
        /** @var Classroom $model */
        return [
            'academic_year_source_id' => (string) $model->academic_year_id,
            'academic_year_name' => $model->academicYear?->name,
            'major_source_id' => $model->major_id ? (string) $model->major_id : null,
            'major_name' => $model->major?->name,
            'homeroom_teacher_source_id' => $model->homeroom_teacher_id ? (string) $model->homeroom_teacher_id : null,
            'name' => $model->name,
            'grade_level' => (int) $model->grade_level,
            'is_active' => (bool) $model->is_active,
        ];
    }

    private function teacherPayload(Model $model): array
    {
        /** @var TeacherProfile $model */
        return [
            'full_name' => $model->full_name,
            'employee_number' => $model->employee_number,
            'nip' => $model->nip,
            'nuptk' => $model->nuptk,
            'dapodik_id' => $model->dapodik_id,
            'email' => $model->email,
            'phone' => $model->phone,
            'gender' => $model->gender,
            'religion' => $model->religion,
            'education_last' => $model->education_last,
            'employment_status' => $model->employment_status,
            'teacher_status' => $model->teacher_status,
            'join_date' => optional($model->join_date)->toDateString(),
            'is_active' => (bool) $model->is_active,
        ];
    }

    private function studentPayload(Model $model): array
    {
        /** @var StudentProfile $model */
        return [
            'full_name' => $model->full_name,
            'nis' => $model->nis,
            'nisn' => $model->nisn,
            'dapodik_id' => $model->dapodik_id,
            'registration_number' => $model->registration_number,
            'major_source_id' => $model->major_id ? (string) $model->major_id : null,
            'birth_place' => $model->birth_place,
            'birth_date' => optional($model->birth_date)->toDateString(),
            'gender' => $model->gender,
            'religion' => $model->religion,
            'phone' => $model->phone,
            'email' => $model->email,
            'address' => $model->address,
            'entry_year' => $model->entry_year,
            'student_status' => $model->student_status,
            'ppdb_status' => $model->ppdb_status,
            'is_alumni' => (bool) $model->is_alumni,
            'is_active' => $model->student_status === 'aktif' && ! $model->is_alumni,
        ];
    }

    private function studentClassMembershipPayload(Model $model): array
    {
        /** @var StudentClassHistory $model */
        return [
            'student_source_id' => (string) $model->student_profile_id,
            'classroom_source_id' => (string) $model->classroom_id,
            'academic_year_source_id' => (string) $model->academic_year_id,
            'semester_source_id' => (string) $model->semester_id,
            'status' => $model->status,
            'start_date' => optional($model->start_date)->toDateString(),
            'end_date' => optional($model->end_date)->toDateString(),
            'is_active' => $this->isStudentClassMembershipActive($model),
        ];
    }

    private function teachingAssignmentPayload(Model $model): array
    {
        /** @var TeachingAssignment $model */
        return [
            'teacher_source_id' => (string) $model->teacher_profile_id,
            'subject_source_id' => (string) $model->subject_id,
            'classroom_source_id' => (string) $model->classroom_id,
            'academic_year_source_id' => (string) $model->academic_year_id,
            'semester_source_id' => (string) $model->semester_id,
            'hours_per_week' => $model->hours_per_week,
            'assignment_status' => $model->assignment_status,
            'start_date' => optional($model->start_date)->toDateString(),
            'end_date' => optional($model->end_date)->toDateString(),
            'is_active' => $this->isTeachingAssignmentActive($model),
        ];
    }

    private function isStudentClassMembershipActive(Model $model): bool
    {
        $status = strtolower((string) $model->status);

        return in_array($status, ['aktif', 'active', 'ongoing', 'berjalan'], true);
    }

    private function isTeachingAssignmentActive(Model $model): bool
    {
        $status = strtolower((string) $model->assignment_status);

        return in_array($status, ['aktif', 'active', 'berjalan'], true);
    }
}
