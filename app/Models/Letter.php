<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_category_id',
        'letter_template_id',
        'letter_number_format_id',
        'created_by_user_id',
        'letter_number',
        'agenda_number',
        'subject',
        'direction',
        'letter_date',
        'status',
        'sender_name',
        'recipient_name',
        'signed_by_name',
        'content',
        'notes',
        'approved_at',
        'signed_at',
        'issued_at',
        'pdf_path',
        'pdf_generated_at',
    ];

    protected function casts(): array
    {
        return [
            'letter_date' => 'date',
            'approved_at' => 'datetime',
            'signed_at' => 'datetime',
            'issued_at' => 'datetime',
            'pdf_generated_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LetterCategory::class, 'letter_category_id')->withDefault();
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(LetterTemplate::class, 'letter_template_id')->withDefault();
    }

    public function numberFormat(): BelongsTo
    {
        return $this->belongsTo(LetterNumberFormat::class, 'letter_number_format_id')->withDefault();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id')->withDefault();
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(LetterRecipient::class);
    }

    public function signatories(): HasMany
    {
        return $this->hasMany(LetterSignatory::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LetterLog::class);
    }

    public function dispositions(): HasMany
    {
        return $this->hasMany(IncomingLetterDisposition::class);
    }
}
