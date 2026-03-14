<?php

namespace App\Models;

use App\Enums\SubjectGroupEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'education_level',
        'school_type_scope',
        'subject_group',
        'major_id',
        'is_productive',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'subject_group' => SubjectGroupEnum::class,
            'is_productive' => 'boolean',
        ];
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class)->withDefault();
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(TeacherProfile::class, 'subject_teacher')
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
}
