<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_profile_id',
        'registration_number',
        'registration_date',
        'origin_school',
        'entry_path',
        'status',
        'documents_verified_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'registration_date' => 'date',
            'documents_verified_at' => 'datetime',
        ];
    }

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
