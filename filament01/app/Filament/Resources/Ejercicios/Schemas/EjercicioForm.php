<?php

namespace App\Filament\Resources\Ejercicios\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;


class EjercicioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('carrito')
                    ->columns(1)
                    ->schema([

                        Repeater::make('miembros')
                            ->columns(3)
                            ->reactive()
                            ->schema([
                                TextInput::make('precio')
                                    ->label('Precio')
                                    ->prefix('$')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $set('sub_total', (($get('cantidad') ?? 0) * $state)); //multiplicamos precio por cantidad y lo ponemos en subtotal
                                    }),


                                TextInput::make('cantidad')
                                    ->label('Cantidad')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $set('sub_total', (($get('precio') ?? 0) * ($state))); //multiplicamos precio por cantidad y lo ponemos en subtotal
                                    }),


                                TextInput::make('sub_total')
                            ])

                            ->afterStateUpdated(function(Set $set, Get $get){
                                $total = collect($get('miembros'))
                                    ->sum(fn ($miembro) => $miembro['sub_total'] ?? 0); //sumamos todos los subtotales de los miembros

                                $set('total', $total);
                            })
                    ]),

                TextInput::make('total')


            ]);
    }
}


                // TextInput::make('numero1')
                //     ->label('Número 1')
                //     //para que cuente el numero1 igual que el numero2
                //     ->reactive()//para que se actualice en tiempo real
                //     ->afterStateUpdated(function($state, $get, $set){
                //         //logica para sumar numero1 y numero2 y poner el resultado en total
                //         $numero2 = $get('numero2');
                //         $numero1 = $state; //el estado actual del campo numero1
                //         $set('total', ($numero1 + $numero2));
                //     }),


                // TextInput::make('numero2')
                //     ->label('Número 2')
                //     ->reactive()//para que se actualice en tiempo real
                //     ->afterStateUpdated(function($state, $get, $set){
                //         //logica para sumar numero1 y numero2 y poner el resultado en total
                //         $numero1 = $get('numero1');
                //         $numero2 = $state; //el estado actual del campo numero2

                //         $set('total', ($numero1 + $numero2));
                //     }),
                // TextInput::make('total')
                //     ->label('Total')
                //     ->disabled() //nadie puede escribir en este campo


                // aqui hacermos ejercicios de funciones anonimas motivo para parender de como se hace

                // TextInput::make('precio')
                //     ->numeric()
                //     ->afterStateUpdated(fn($state, $set) => $set('total', $state)), //$state es el valor que tiene el campo despues de ser actualizado
                //     //afterStateUpdated es un metodo que se ejecuta despues de que se actualiza el estado del campo
                //     //$set es una funcion que nos permite actualizar el estado de otro campo
                //     //$reactive es una funcion que nos permite actualizar el estado del campo actual en funcion del estado de otro campo
                    
                // TextInput::make('total'),
                   