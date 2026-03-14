<?php

namespace App\Filament\Resources\AlumniProfiles;

use App\Filament\Resources\AlumniProfiles\Pages\CreateAlumniProfile;
use App\Filament\Resources\AlumniProfiles\Pages\EditAlumniProfile;
use App\Filament\Resources\AlumniProfiles\Pages\ListAlumniProfiles;
use App\Filament\Resources\AlumniProfiles\Schemas\AlumniProfileForm;
use App\Filament\Resources\AlumniProfiles\Tables\AlumniProfilesTable;
use App\Models\AlumniProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AlumniProfileResource extends Resource
{
    protected static ?string $model = AlumniProfile::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Siswa';

    protected static ?string $navigationLabel = 'Data Alumni';

    protected static ?string $modelLabel = 'Alumni';

    protected static ?string $pluralModelLabel = 'Data Alumni';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return AlumniProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumniProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlumniProfiles::route('/'),
            'create' => CreateAlumniProfile::route('/create'),
            'edit' => EditAlumniProfile::route('/{record}/edit'),
        ];
    }
}
