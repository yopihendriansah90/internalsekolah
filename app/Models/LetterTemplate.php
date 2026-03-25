<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_category_id',
        'name',
        'code',
        'subject_template',
        'body_html',
        'placeholders',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'placeholders' => 'array',
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
