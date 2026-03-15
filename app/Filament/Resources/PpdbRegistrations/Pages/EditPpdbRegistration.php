<?php

namespace App\Filament\Resources\PpdbRegistrations\Pages;

use App\Filament\Resources\PpdbRegistrations\PpdbRegistrationResource;
use App\Filament\Resources\StudentProfiles\StudentProfileResource;
use App\Filament\Resources\Pages\BaseEditRecord;
use App\Services\Admissions\PpdbAdmissionService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class EditPpdbRegistration extends BaseEditRecord
{
    protected static string $resource = PpdbRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('admitStudent')
                ->label('Terima Sebagai Siswa')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn (): bool => blank($this->getRecord()->student_profile_id))
                ->form([
                    TextInput::make('nis')
                        ->label('NIS')
                        ->required()
                        ->maxLength(50),
                    Select::make('major_id')
                        ->label('Struktur Akademik')
                        ->relationship('major', 'name')
                        ->searchable()
                        ->preload()
                        ->default(fn (): ?int => $this->getRecord()->major_id),
                    TextInput::make('entry_year')
                        ->label('Tahun Masuk')
                        ->numeric()
                        ->default((int) now()->format('Y'))
                        ->required(),
                ])
                ->action(function (array $data, PpdbAdmissionService $service): void {
                    $service->admit($this->getRecord(), $data);

                    Notification::make()
                        ->title('Calon siswa berhasil diterima menjadi siswa resmi.')
                        ->success()
                        ->send();

                    $this->redirect(StudentProfileResource::getUrl('edit', ['record' => $this->getRecord()->fresh()->student_profile_id]));
                }),
            Action::make('openStudent')
                ->label('Buka Data Siswa')
                ->icon('heroicon-o-user')
                ->color('gray')
                ->visible(fn (): bool => filled($this->getRecord()->student_profile_id))
                ->url(fn (): string => StudentProfileResource::getUrl('edit', ['record' => $this->getRecord()->student_profile_id])),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['status'] ?? null) === 'diterima' && blank($this->getRecord()->student_profile_id)) {
            throw ValidationException::withMessages([
                'data.status' => 'Gunakan aksi "Terima Sebagai Siswa" agar data siswa resmi terbentuk.',
            ]);
        }

        return $data;
    }
}
