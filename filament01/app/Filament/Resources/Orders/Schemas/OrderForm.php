<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informacion de la venta')
                    ->schema([
                        Select::make('warehouse_id')
                            ->relationship('warehouse', 'name')
                            ->required(),
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->required(),
                        // Select::make('user_id')
                        //     ->relationship('user', 'name')
                        //     ->required(),
                        // TextInput::make('total')
                        //     ->required()
                        //     ->numeric(),
                        Textarea::make('notes')
                            ->columnSpanFull(),

                    ]),

            ]);
    }
}
