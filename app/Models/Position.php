<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
    ];

    public function teacherPositions(): HasMany
    {
        return $this->hasMany(TeacherPosition::class);
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(TeacherProfile::class, 'teacher_positions')
            ->withPivot(['id', 'start_date', 'end_date', 'is_active', 'decree_number', 'notes'])
            ->withTimestamps();
    }
}
