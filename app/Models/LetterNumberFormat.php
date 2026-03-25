<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterNumberFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_category_id',
        'name',
        'code',
        'format_pattern',
        'sequence_reset_period',
        'current_sequence',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'current_sequence' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LetterCategory::class, 'letter_category_id')->withDefault();
    }

    public function letters(): HasMany
    {
        return $this->hasMany(Letter::class);
    }
}
