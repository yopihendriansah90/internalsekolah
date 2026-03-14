<?php

namespace App\Filament\Pages;

use App\Enums\SchoolTypeEnum;
use App\Enums\SystemSettingKeyEnum;
use App\Models\School;
use App\Models\SystemSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SetupApplication extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.setup-application';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Konfigurasi Awal';

    protected static ?string $title = 'Konfigurasi Awal Aplikasi';

    protected static ?string $slug = 'konfigurasi-awal';

    protected static ?int $navigationSort = -100;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    public ?array $data = [];

    public function mount(): void
    {
        $schoolId = SystemSetting::getValue(SystemSettingKeyEnum::ActiveSchoolId);
        $school = is_numeric($schoolId) ? School::query()->find((int) $schoolId) : null;

        $this->form->fill([
            'name' => $school?->name,
            'school_type' => $school?->school_type?->value,
            'npsn' => $school?->npsn,
            'email' => $school?->email,
            'phone' => $school?->phone,
            'address' => $school?->address,
            'principal_name' => $school?->principal_name,
            'principal_nip' => $school?->principal_nip,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Profil Sekolah')
                    ->description('Atur identitas sekolah aktif dan tipe sekolah yang akan dipakai sistem.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Sekolah')
                            ->required()
                            ->maxLength(255),
                        Select::make('school_type')
                            ->label('Tipe Sekolah')
                            ->options(SchoolTypeEnum::options())
                            ->required()
                            ->native(false),
                        TextInput::make('npsn')
                            ->label('NPSN')
                            ->maxLength(50),
                        TextInput::make('email')
                            ->label('Email Sekolah')
                            ->email(),
                        TextInput::make('phone')
                            ->label('Telepon Sekolah')
                            ->tel(),
                        Textarea::make('address')
                            ->label('Alamat Sekolah')
                            ->rows(3),
                        TextInput::make('principal_name')
                            ->label('Nama Kepala Sekolah'),
                        TextInput::make('principal_nip')
                            ->label('NIP Kepala Sekolah'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Konfigurasi')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $schoolId = SystemSetting::getValue(SystemSettingKeyEnum::ActiveSchoolId);
        $school = is_numeric($schoolId) ? School::query()->find((int) $schoolId) : new School();

        $school->fill($state);
        $school->save();

        SystemSetting::putValue(SystemSettingKeyEnum::ActiveSchoolId, $school->id, 'integer');
        SystemSetting::putValue(SystemSettingKeyEnum::AppInitialized, true, 'boolean');
        SystemSetting::putValue(SystemSettingKeyEnum::DefaultLocale, app()->getLocale(), 'string', true);
        SystemSetting::putValue(SystemSettingKeyEnum::AllowSchoolTypeChange, false, 'boolean');

        Notification::make()
            ->title('Konfigurasi awal berhasil disimpan.')
            ->success()
            ->send();
    }
}
