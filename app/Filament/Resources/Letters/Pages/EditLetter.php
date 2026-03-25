<?php

namespace App\Filament\Resources\Letters\Pages;

use App\Filament\Resources\Letters\LetterResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use App\Models\Letter;
use App\Services\Letter\LetterPdfService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;

class EditLetter extends BaseEditRecord
{
    protected static string $resource = LetterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('previewPdf')
                ->label('Preview PDF')
                ->icon('heroicon-o-eye')
                ->url(fn (Letter $record): string => route('letters.pdf.preview', ['letter' => $record]))
                ->openUrlInNewTab(),
            Action::make('generatePdf')
                ->label('Generate & Simpan PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function (Letter $record, LetterPdfService $pdfService): void {
                    $path = $pdfService->saveToDisk($record);
                    $record->update([
                        'pdf_path' => $path,
                        'pdf_generated_at' => now(),
                    ]);

                    Notification::make()
                        ->title('PDF surat berhasil dibuat.')
                        ->body("Tersimpan di: {$path}")
                        ->success()
                        ->send();
                }),
            ActionGroup::make([
                Action::make('downloadPdf')
                    ->label('Download PDF Langsung')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Letter $record): string => route('letters.pdf.download', ['letter' => $record]))
                    ->openUrlInNewTab(),
                Action::make('downloadStoredPdf')
                    ->label('Download File Tersimpan')
                    ->icon('heroicon-o-folder-arrow-down')
                    ->visible(fn (Letter $record): bool => filled($record->pdf_path))
                    ->url(fn (Letter $record): string => route('letters.pdf.download-stored', ['letter' => $record]))
                    ->openUrlInNewTab(),
                DeleteAction::make(),
            ])->label('Aksi Lanjutan'),
        ];
    }
}
