<?php

namespace App\Filament\Resources\TeacherPositions;

use App\Filament\Resources\TeacherPositions\Pages\CreateTeacherPosition;
use App\Filament\Resources\TeacherPositions\Pages\EditTeacherPosition;
use App\Filament\Resources\TeacherPositions\Pages\ListTeacherPositions;
use App\Filament\Resources\TeacherPositions\Schemas\TeacherPositionForm;
use App\Filament\Resources\TeacherPositions\Tables\TeacherPositionsTable;
use App\Models\TeacherPosition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TeacherPositionResource extends Resource
{
    protected static ?string $model = TeacherPosition::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Guru';

    protected static ?string $navigationLabel = 'Jabatan Guru';

    protected static ?string $modelLabel = 'Jabatan Guru';

    protected static ?string $pluralModelLabel = 'Jabatan Guru';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return TeacherPositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeacherPositionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeacherPositions::route('/'),
            'create' => CreateTeacherPosition::route('/create'),
            'edit' => EditTeacherPosition::route('/{record}/edit'),
        ];
    }
}
