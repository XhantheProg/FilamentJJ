<?php

namespace App\Filament\Resources\Ejercicios;

use App\Filament\Resources\Ejercicios\Pages\CreateEjercicio;
use App\Filament\Resources\Ejercicios\Pages\EditEjercicio;
use App\Filament\Resources\Ejercicios\Pages\ListEjercicios;
use App\Filament\Resources\Ejercicios\Schemas\EjercicioForm;
use App\Filament\Resources\Ejercicios\Tables\EjerciciosTable;
use App\Models\Ejercicio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EjercicioResource extends Resource
{
    protected static ?string $model = Ejercicio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Ejercicio';

    public static function form(Schema $schema): Schema
    {
        return EjercicioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EjerciciosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEjercicios::route('/'),
            'create' => CreateEjercicio::route('/create'),
            'edit' => EditEjercicio::route('/{record}/edit'),
        ];
    }
}
