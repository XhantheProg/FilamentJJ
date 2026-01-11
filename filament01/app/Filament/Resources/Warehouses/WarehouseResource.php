<?php

namespace App\Filament\Resources\Warehouses;

use App\Filament\Resources\Warehouses\Pages\CreateWarehouse;
use App\Filament\Resources\Warehouses\Pages\EditWarehouse;
use App\Filament\Resources\Warehouses\Pages\ListWarehouses;
use App\Filament\Resources\Warehouses\Schemas\WarehouseForm;
use App\Filament\Resources\Warehouses\Tables\WarehousesTable;
use App\Models\Warehouse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WarehouseResource extends Resource
{

    protected static ?string $navigationLabel = 'Almacenes';
    protected static ?string $label = 'Almacèn';
    protected static ?string $pluralLabel = 'Almecenes';

    protected static ?string $slug = 'almacenes';
    protected static string|UnitEnum|null $navigationGroup = 'Administración';
    protected static ?string $model = Warehouse::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $recordTitleAttribute = 'Warehouse';

    public static function form(Schema $schema): Schema
    {
        return WarehouseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WarehousesTable::configure($table);
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
            'index' => ListWarehouses::route('/'),
            // 'create' => CreateWarehouse::route('/create'), se comante para que no se pueda crear desde el panel
            // 'edit' => EditWarehouse::route('/{record}/edit'),
        ];
    }
}