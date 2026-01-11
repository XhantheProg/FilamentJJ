<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Cliente')
                    ->columns(2)
                    ->schema([

                        TextInput::make('name')
                            ->label('Nombre')
                            ->required(),

                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email() //valida que sea un correo
                            ->unique(table: 'customers', column: 'email')
                            ->validationMessages([ //personaliza el mensaje de error
                                'unique' => 'El correo ya esta registrado 🥲'
                            ])
                            ->default(null),

                        TextInput::make('phone')
                            ->label('Telefono')
                            ->tel()
                            ->unique(table: 'customers', column: 'phone')
                            ->validationMessages([
                                'unique' => 'El telefono ya esta registrado en el sistema'
                            ])
                            ->default(null),

                        TextInput::make('nit')
                            ->label('NIT / Razón social')
                             ->unique(table: 'customers', column: 'nit')
                            ->validationMessages([
                                'unique' => 'El NIT ya esta registrado en el sistema'
                            ])
                            ->required(),

                        Toggle::make('is_active')
                            ->label('¿Activo?')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }
}

