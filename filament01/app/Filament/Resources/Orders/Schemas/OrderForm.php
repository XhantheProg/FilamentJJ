<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Inventory;
use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;

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
                    ->live()
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
                                    ->live()
                                    ->required()
                                    ->disabled(function(Get $get){
                                       $warehouseId= $get('../../warehouse_id');
                                       if(!$warehouseId){
                                        return true;
                                       }
                                        return !Product ::whereHas('inventories', function ($query) use ($warehouseId) { // verificamos si hay productos en el warehouse seleccionado
                                            $query->where('warehouse_id', $warehouseId);
                                        })->exists(); //si no existen productos en el warehouse seleccionado, deshabilitamos el select
                                    })
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
                                    ->live()
                                    ->minValue(1)
                                    ->label('Cantidad')
                                    ->helperText(function (Get $get) {
                                        $productId = $get('product_id');
                                        $warehouseId = $get('../../warehouse_id');

                                        $stock= Inventory::where('product_id', $productId)
                                        ->where('warehouse_id', $warehouseId)
                                        ->value('quantity') ?? 0;

                                        return "Stock disponible: {$stock}";
                                    })
                                    
                                    ->afterStateUpdated(function(Get $get, Set $set, $state){
                                        $productId = $get('product_id');
                                        $quantity = $get('quantity');

                                        $product = Product::find($productId); //obtenemos el producto seleccionado
                                        $subtotal = ($quantity * $product->price); //calculamos el subtotal -> significa que el producto tiene un precio fijo "->" significa que quiero de producto el precio y lo multiploque el quntity
                                        $set('sub_total', $subtotal);
                                    })
                                    ->rule(function(Get $get){
                                        $productId = $get('product_id');
                                        $warehouseId = $get('../../warehouse_id');

                                        $stock= Inventory::where('product_id', $productId)
                                        ->where('warehouse_id', $warehouseId)
                                        ->value('quantity') ?? 0;

                                        return "max:{$stock}"; //la cantidad maxima sera el stock disponible
                                    })
                                    ->validationMessages( [
                                        'max' => 'La cantidad excede el stock disponible.',
                                    ]),

                                TextInput::make('sub_total')
                                ->numeric()
                                ->minValue(0)
                                ->label('Subtotal'),
                            ])
                            ->afterStateUpdated(function(Get $get, Set $set, $state){
                                $total = 0;

                                foreach($state as $item){
                                    $productId = $item['product_id'];
                                    $quantity = $item['quantity'] ?? 0;

                                    $product = Product::find($productId);

                                    $total += (float) $quantity * (float)($product->price ?? 0);
                                }

                                $set('total', $total);
                            }),
                           
                    ]),
                Section::make('Resumen de la orden')
                    ->hidden(function (Get $get):bool {
                        $isvisible = (empty($get('warehouse_id')) || (empty($get('customer_id')))); //si warehouse o customer estan vacios entonces oculta el section
                        return $isvisible;
                    })
                    ->columns(2)
                    ->schema([
                        TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->disabled()
                            ->default(0),
                    ]),
            ]);
    }
}
