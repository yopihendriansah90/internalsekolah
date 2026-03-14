<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TeacherProfile extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_number',
        'nip',
        'nuptk',
        'dapodik_id',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'phone',
        'email',
        'address',
        'education_last',
        'employment_status',
        'teacher_status',
        'join_date',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'join_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher')
            ->withPivot(['id', 'academic_year_id', 'competency_notes', 'notes'])
            ->withTimestamps();
    }

    public function subjectTeachers(): HasMany
    {
        return $this->hasMany(SubjectTeacher::class);
    }

    public function teachingAssignments(): HasMany
    {
        return $this->hasMany(TeachingAssignment::class);
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'teacher_positions')
            ->withPivot(['id', 'start_date', 'end_date', 'is_active', 'decree_number', 'notes'])
            ->withTimestamps();
    }

    public function teacherPositions(): HasMany
    {
        return $this->hasMany(TeacherPosition::class);
    }

    public function additionalAssignments(): HasMany
    {
        return $this->hasMany(AdditionalAssignment::class);
    }

    public function homeroomClassrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'homeroom_teacher_id');
    }
}
