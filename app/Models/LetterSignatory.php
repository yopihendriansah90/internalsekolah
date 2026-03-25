<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterSignatory extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'signatory_name',
        'signatory_position',
        'signature_date',
        'signature_image_path',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'signature_date' => 'date',
            'is_primary' => 'boolean',
        ];
    }

    public function letter(): BelongsTo
    {
        return $this->belongsTo(Letter::class);
    }
}
