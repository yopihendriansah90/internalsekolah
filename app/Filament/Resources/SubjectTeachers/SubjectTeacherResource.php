<?php

namespace App\Filament\Resources\SubjectTeachers;

use App\Filament\Resources\SubjectTeachers\Pages\CreateSubjectTeacher;
use App\Filament\Resources\SubjectTeachers\Pages\EditSubjectTeacher;
use App\Filament\Resources\SubjectTeachers\Pages\ListSubjectTeachers;
use App\Filament\Resources\SubjectTeachers\Schemas\SubjectTeacherForm;
use App\Filament\Resources\SubjectTeachers\Tables\SubjectTeachersTable;
use App\Models\SubjectTeacher;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SubjectTeacherResource extends Resource
{
    protected static ?string $model = SubjectTeacher::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Guru';

    protected static ?string $navigationLabel = 'Kompetensi Guru Mapel';

    protected static ?string $modelLabel = 'Kompetensi Guru Mapel';

    protected static ?string $pluralModelLabel = 'Kompetensi Guru Mapel';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return SubjectTeacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubjectTeachersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubjectTeachers::route('/'),
            'create' => CreateSubjectTeacher::route('/create'),
            'edit' => EditSubjectTeacher::route('/{record}/edit'),
        ];
    }
}
