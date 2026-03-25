<?php

namespace App\Filament\Resources\LetterCategories;

use App\Filament\Resources\LetterCategories\Pages\CreateLetterCategory;
use App\Filament\Resources\LetterCategories\Pages\EditLetterCategory;
use App\Filament\Resources\LetterCategories\Pages\ListLetterCategories;
use App\Filament\Resources\LetterCategories\Schemas\LetterCategoryForm;
use App\Filament\Resources\LetterCategories\Tables\LetterCategoriesTable;
use App\Models\LetterCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class LetterCategoryResource extends Resource
{
    protected static ?string $model = LetterCategory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Surat Dinas';

    protected static ?string $navigationLabel = 'Kategori Surat';

    protected static ?string $modelLabel = 'Kategori Surat';

    protected static ?string $pluralModelLabel = 'Kategori Surat';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return LetterCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LetterCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLetterCategories::route('/'),
            'create' => CreateLetterCategory::route('/create'),
            'edit' => EditLetterCategory::route('/{record}/edit'),
        ];
    }
}
