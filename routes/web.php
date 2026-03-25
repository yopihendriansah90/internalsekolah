<?php

use App\Http\Controllers\LetterPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::middleware('auth')->prefix('admin/letters/{letter}/pdf')->name('letters.pdf.')->group(function (): void {
    Route::get('preview', [LetterPdfController::class, 'preview'])->name('preview');
    Route::get('download', [LetterPdfController::class, 'download'])->name('download');
    Route::get('download-stored', [LetterPdfController::class, 'downloadStored'])->name('download-stored');
});
