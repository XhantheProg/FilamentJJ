<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                Section::make('Informacion de la venta')
                    ->columns(2)
                    ->schema([
                        Select::make('warehouse_id')
                            ->relationship('warehouse', 'name')
                            ->live()
                            ->default(null)
                            ->label('Almacen'),

                        Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->live()
                            ->default(null),
                        // Select::make('user_id')
                        //     ->relationship('user', 'name')
                        //     ->required(),
                        // TextInput::make('total')
                        //     ->required()
                        //     ->numeric(),
                        Textarea::make('notes')
                            ->label('Notas')
                            ->default(null)
                            ->columnSpanFull(),

                    ]),


                Section::make('Carrrito de compras')
                    ->columns(1)
                    ->hidden(function (Get $get) {
                        $isvisible = (empty($get('warehouse_id')) || (empty($get('customer_id')))); //si warehouse o customer estan vacios entonces oculta el section
                        return $isvisible;
                    })
                    ->schema([
                        // Aquí puedes agregar componentes para mostrar los productos en el carrito

                        Repeater::make('orderProducts')
                            ->columns(3)
                            ->relationship('orderProducts') //relacion con orderProducts
                            ->schema([
                                Select::make('product_id')
                                    ->label('Producto')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->relationship('product', 'name')
                                    ->options(function (Get $get): array {
                                        $warehouseId = $get('../../warehouse_id'); //obtenemos el id del warehouse seleccionado "../.." para subir un nivel en el array

                                        $product = Product::whereHas('inventories', function ($query) use ($warehouseId) { // filtramos los productos que tienen inventario en el warehouse seleccionado
                                            $query->where('warehouse_id', $warehouseId); //filtramos los productos que tienen inventario en el warehouse seleccionado
                                        })
                                            ->pluck('name', 'id')->toArray(); //obtenemos los productos filtrados por warehouse

                                        return $product;
                                    }),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->label('Cantidad'),

                                TextInput::make('sub_total')
                                ->numeric()
                                ->minValue(0)
                                ->label('Subtotal'),
                            ])
                           
                    ]),
            ]);
    }
}
