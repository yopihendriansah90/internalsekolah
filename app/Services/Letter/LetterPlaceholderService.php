<?php

namespace App\Services\Letter;

use App\Models\Letter;

class LetterPlaceholderService
{
    /**
     * @return array<string, string>
     */
    public function forLetter(Letter $letter): array
    {
        return [
            'subject' => (string) ($letter->subject ?? ''),
            'letter_number' => (string) ($letter->letter_number ?? ''),
            'agenda_number' => (string) ($letter->agenda_number ?? ''),
            'direction' => (string) ($letter->direction ?? ''),
            'status' => (string) ($letter->status ?? ''),
            'letter_date' => $letter->letter_date?->format('Y-m-d') ?? '',
            'sender_name' => (string) ($letter->sender_name ?? ''),
            'recipient_name' => (string) ($letter->recipient_name ?? ''),
            'signed_by_name' => (string) ($letter->signed_by_name ?? ''),
            'category_name' => (string) ($letter->category?->name ?? ''),
            // Kode kategori sengaja tidak diekspos ke placeholder publik.
        ];
    }
}
