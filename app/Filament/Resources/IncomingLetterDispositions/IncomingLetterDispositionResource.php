<?php

namespace App\Filament\Resources\IncomingLetterDispositions;

use App\Filament\Resources\IncomingLetterDispositions\Pages\CreateIncomingLetterDisposition;
use App\Filament\Resources\IncomingLetterDispositions\Pages\EditIncomingLetterDisposition;
use App\Filament\Resources\IncomingLetterDispositions\Pages\ListIncomingLetterDispositions;
use App\Filament\Resources\IncomingLetterDispositions\Schemas\IncomingLetterDispositionForm;
use App\Filament\Resources\IncomingLetterDispositions\Tables\IncomingLetterDispositionsTable;
use App\Models\IncomingLetterDisposition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class IncomingLetterDispositionResource extends Resource
{
    protected static ?string $model = IncomingLetterDisposition::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static string|\UnitEnum|null $navigationGroup = 'Modul Surat Dinas';

    protected static ?string $navigationLabel = 'Disposisi Surat Masuk';

    protected static ?string $modelLabel = 'Disposisi Surat Masuk';

    protected static ?string $pluralModelLabel = 'Disposisi Surat Masuk';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return IncomingLetterDispositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IncomingLetterDispositionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomingLetterDispositions::route('/'),
            'create' => CreateIncomingLetterDisposition::route('/create'),
            'edit' => EditIncomingLetterDisposition::route('/{record}/edit'),
        ];
    }
}
