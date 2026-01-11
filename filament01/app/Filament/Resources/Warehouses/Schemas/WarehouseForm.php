<?php

namespace App\Filament\Resources\Warehouses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WarehouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Almacén')
                    ->description('Esta es la informacion de tus alamcenes')
                    ->icon('heroicon-o-building-office')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('address')
                            ->label('Direcciòn')
                            ->required(),
                    ])
            ]);
    }
}
