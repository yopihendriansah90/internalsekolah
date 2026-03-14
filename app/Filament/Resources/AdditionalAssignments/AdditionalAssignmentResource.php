<?php

namespace App\Filament\Resources\AdditionalAssignments;

use App\Filament\Resources\AdditionalAssignments\Pages\CreateAdditionalAssignment;
use App\Filament\Resources\AdditionalAssignments\Pages\EditAdditionalAssignment;
use App\Filament\Resources\AdditionalAssignments\Pages\ListAdditionalAssignments;
use App\Filament\Resources\AdditionalAssignments\Schemas\AdditionalAssignmentForm;
use App\Filament\Resources\AdditionalAssignments\Tables\AdditionalAssignmentsTable;
use App\Models\AdditionalAssignment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AdditionalAssignmentResource extends Resource
{
    protected static ?string $model = AdditionalAssignment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Guru';

    protected static ?string $navigationLabel = 'Tugas Tambahan Guru';

    protected static ?string $modelLabel = 'Tugas Tambahan Guru';

    protected static ?string $pluralModelLabel = 'Tugas Tambahan Guru';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return AdditionalAssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdditionalAssignmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdditionalAssignments::route('/'),
            'create' => CreateAdditionalAssignment::route('/create'),
            'edit' => EditAdditionalAssignment::route('/{record}/edit'),
        ];
    }
}
