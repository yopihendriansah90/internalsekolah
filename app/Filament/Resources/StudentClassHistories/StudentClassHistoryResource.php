<?php

namespace App\Filament\Resources\StudentClassHistories;

use App\Filament\Resources\StudentClassHistories\Pages\CreateStudentClassHistory;
use App\Filament\Resources\StudentClassHistories\Pages\EditStudentClassHistory;
use App\Filament\Resources\StudentClassHistories\Pages\ListStudentClassHistories;
use App\Filament\Resources\StudentClassHistories\Schemas\StudentClassHistoryForm;
use App\Filament\Resources\StudentClassHistories\Tables\StudentClassHistoriesTable;
use App\Models\StudentClassHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StudentClassHistoryResource extends Resource
{
    protected static ?string $model = StudentClassHistory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Siswa';

    protected static ?string $navigationLabel = 'Riwayat Kelas Siswa';

    protected static ?string $modelLabel = 'Riwayat Kelas';

    protected static ?string $pluralModelLabel = 'Riwayat Kelas Siswa';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return StudentClassHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentClassHistoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentClassHistories::route('/'),
            'create' => CreateStudentClassHistory::route('/create'),
            'edit' => EditStudentClassHistory::route('/{record}/edit'),
        ];
    }
}
