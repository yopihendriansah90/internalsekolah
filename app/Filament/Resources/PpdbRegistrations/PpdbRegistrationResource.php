<?php

namespace App\Filament\Resources\PpdbRegistrations;

use App\Filament\Resources\PpdbRegistrations\Pages\CreatePpdbRegistration;
use App\Filament\Resources\PpdbRegistrations\Pages\EditPpdbRegistration;
use App\Filament\Resources\PpdbRegistrations\Pages\ListPpdbRegistrations;
use App\Filament\Resources\PpdbRegistrations\Schemas\PpdbRegistrationForm;
use App\Filament\Resources\PpdbRegistrations\Tables\PpdbRegistrationsTable;
use App\Filament\Resources\StudentProfiles\StudentProfileResource;
use App\Models\PpdbRegistration;
use App\Services\Admissions\PpdbAdmissionService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;

class PpdbRegistrationResource extends Resource
{
    protected static ?string $model = PpdbRegistration::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Siswa';

    protected static ?string $navigationLabel = 'Data PPDB';

    protected static ?string $modelLabel = 'PPDB';

    protected static ?string $pluralModelLabel = 'Data PPDB';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PpdbRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PpdbRegistrationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPpdbRegistrations::route('/'),
            'create' => CreatePpdbRegistration::route('/create'),
            'edit' => EditPpdbRegistration::route('/{record}/edit'),
        ];
    }

    public static function getAdmitStudentAction(): Action
    {
        return Action::make('admitStudent')
            ->label('Terima Sebagai Siswa')
            ->icon('heroicon-o-check-badge')
            ->color('success')
            ->visible(fn (PpdbRegistration $record): bool => blank($record->student_profile_id))
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
                    ->default(fn (PpdbRegistration $record): ?int => $record->major_id),
                TextInput::make('entry_year')
                    ->label('Tahun Masuk')
                    ->numeric()
                    ->default((int) now()->format('Y'))
                    ->required(),
            ])
            ->action(function (array $data, PpdbRegistration $record, PpdbAdmissionService $service): void {
                $service->admit($record, $data);

                Notification::make()
                    ->title('Calon siswa berhasil diterima menjadi siswa resmi.')
                    ->success()
                    ->send();
            });
    }

    public static function getOpenStudentAction(): Action
    {
        return Action::make('openStudent')
            ->label('Buka Data Siswa')
            ->icon('heroicon-o-user')
            ->color('gray')
            ->visible(fn (PpdbRegistration $record): bool => filled($record->student_profile_id))
            ->url(fn (PpdbRegistration $record): string => StudentProfileResource::getUrl('edit', ['record' => $record->student_profile_id]));
    }
}
