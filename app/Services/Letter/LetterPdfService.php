<?php

namespace App\Services\Letter;

use App\Models\Letter;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class LetterPdfService
{
    public function __construct(
        protected LetterTemplateRenderService $renderService,
    ) {}

    public function inlineResponse(Letter $letter): PdfBuilder
    {
        return $this->makeBuilder($letter)
            ->name($this->fileName($letter))
            ->inline();
    }

    public function downloadResponse(Letter $letter): PdfBuilder
    {
        return $this->makeBuilder($letter)
            ->name($this->fileName($letter))
            ->download();
    }

    public function saveToDisk(Letter $letter, string $disk = 'local'): string
    {
        $path = 'letters/pdf/'.$this->fileName($letter);

        $this->makeBuilder($letter)
            ->disk($disk, 'private')
            ->save($path);

        return $path;
    }

    protected function makeBuilder(Letter $letter): PdfBuilder
    {
        $rendered = $this->renderService->renderForLetter($letter);

        return Pdf::driver('dompdf')
            ->view('pdf.letter', [
                'letter' => $letter,
                'subject' => $rendered['subject'],
                'contentHtml' => $rendered['content'],
            ]);
    }

    protected function fileName(Letter $letter): string
    {
        $subject = Str::slug((string) $letter->subject ?: 'surat');
        $date = now()->format('Y-m-d');

        return "surat-{$subject}-{$date}.pdf";
    }
}
