<?php

namespace App\Filament\Resources\Inventories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informaciòn del invetarios')
                    ->columns(2)
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->label('Producto')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Seleccione un producto')
                            ->default(null),

                        Select::make('warehouse_id')
                            ->label('Almacenes')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Seleccione Almacèn')
                            ->relationship('warehouse', 'name')
                            ->default(null),

                        TextInput::make('quantity')
                            ->label('Cantidad de Stock')
                            ->columnSpan(2)
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
            ]);
    }
}