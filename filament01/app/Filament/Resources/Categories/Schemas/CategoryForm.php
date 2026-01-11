<?php
//Aqui se crea o se edita el formulario de creacion de alguna categoria
namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informacion de la categoria')
                    ->description('Configure los detalles de su categoria')
                    ->collapsible()//aqui se vuelve un desplegable
                    ->icon('heroicon-o-academic-cap')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Nombre'),

                        TextInput::make('slug')
                            ->required()
                            ->label('Slug'),
                            
                        TextInput::make('summary')
                            ->required()
                            ->label('Resumen'),

                    ])

            ]);
    }
}
