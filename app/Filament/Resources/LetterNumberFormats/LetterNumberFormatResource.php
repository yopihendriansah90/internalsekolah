<?php

namespace App\Filament\Resources\LetterNumberFormats;

use App\Filament\Resources\LetterNumberFormats\Pages\CreateLetterNumberFormat;
use App\Filament\Resources\LetterNumberFormats\Pages\EditLetterNumberFormat;
use App\Filament\Resources\LetterNumberFormats\Pages\ListLetterNumberFormats;
use App\Filament\Resources\LetterNumberFormats\Schemas\LetterNumberFormatForm;
use App\Filament\Resources\LetterNumberFormats\Tables\LetterNumberFormatsTable;
use App\Models\LetterNumberFormat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class LetterNumberFormatResource extends Resource
{
    protected static ?string $model = LetterNumberFormat::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-hashtag';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Surat Dinas';

    protected static ?string $navigationLabel = 'Format Nomor Surat';

    protected static ?string $modelLabel = 'Format Nomor Surat';

    protected static ?string $pluralModelLabel = 'Format Nomor Surat';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return LetterNumberFormatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LetterNumberFormatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLetterNumberFormats::route('/'),
            'create' => CreateLetterNumberFormat::route('/create'),
            'edit' => EditLetterNumberFormat::route('/{record}/edit'),
        ];
    }
}
