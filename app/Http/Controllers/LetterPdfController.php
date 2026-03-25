<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Services\Letter\LetterPdfService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class LetterPdfController extends Controller
{
    public function preview(Letter $letter, LetterPdfService $pdfService)
    {
        Gate::authorize('view', $letter);

        return $pdfService->inlineResponse($letter);
    }

    public function download(Letter $letter, LetterPdfService $pdfService)
    {
        Gate::authorize('view', $letter);

        return $pdfService->downloadResponse($letter);
    }

    public function downloadStored(Letter $letter)
    {
        Gate::authorize('view', $letter);

        $path = (string) ($letter->pdf_path ?? '');

        abort_if(blank($path), 404, 'File PDF belum tersedia.');
        abort_unless(Storage::disk('local')->exists($path), 404, 'File PDF tersimpan tidak ditemukan.');

        return Storage::disk('local')->download($path, basename($path));
    }
}
