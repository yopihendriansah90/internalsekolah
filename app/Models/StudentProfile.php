<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StudentProfile extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'nis',
        'nisn',
        'dapodik_id',
        'registration_number',
        'major_id',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'phone',
        'email',
        'address',
        'guardian_name',
        'guardian_phone',
        'entry_year',
        'student_status',
        'ppdb_status',
        'graduation_year',
        'is_alumni',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'entry_year' => 'integer',
            'graduation_year' => 'integer',
            'is_alumni' => 'boolean',
        ];
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class)->withDefault();
    }

    public function ppdbRegistration(): HasOne
    {
        return $this->hasOne(PpdbRegistration::class);
    }

    public function alumniProfile(): HasOne
    {
        return $this->hasOne(AlumniProfile::class);
    }

    public function classHistories(): HasMany
    {
        return $this->hasMany(StudentClassHistory::class);
    }
}
