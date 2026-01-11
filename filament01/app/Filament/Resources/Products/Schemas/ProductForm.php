<?php

namespace App\Filament\Resources\Products\Schemas;

use Dom\Text;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use function Laravel\Prompts\select;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1) //ocupa todo el espacio
            ->components([
                Section::make('Informacion del Producto')
                    ->columns(3) //sse divide en 3 dentro de la seccion
                    ->schema([
                        Toggle::make('Is active?') //toggle boton de activo o inactivo
                            ->columnSpan(3) //aqui se baja los imputs
                            ->label('Activo?')
                            ->required()
                            ->default(true), //por default el bootn esta encendido

                        TextInput::make('code')
                            ->label('Codigo')
                            ->placeholder('OBJ-102')
                            ->required()
                            ->alphaDash(), //solo se inserte letras mayusculas minusculas y 0-9


                        TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('EJ. Telefono Televisor')
                            ->required(),

                        TextInput::make('summary')
                            ->label('Resumen')
                            ->required()   
                            ->placeholder('Resumen del producto'),
                        
                        TextInput::make('price')    
                            ->numeric()//un imput para que sea solo numero  
                            ->minValue(0)
                            ->prefix('$') //aqui se usa el prefijo de lo que sea
                            ->required()
                            ->step(0,01),//talvel sea eso para centavos   
                        
                        Select::make('category_id')
                            ->label('Crear nueva categoria')
                            ->relationship('category', 'name') //enlaza los nombres de las categoruias
                            ->searchable() //busca las categorais
                            ->preload()//carga as categorias
                    ]),
                Section::make('Imagen del Producto')
                    ->schema([
                        FileUpload::make('image')
                        ->label('Imagen')
                        ->disk('public') //automaticamnte lo almacena las fotos 
                        ->directory('products') //como se va  allamar la carpeta
                        ->image()
                        ->acceptedFileTypes([
                            // 'image/png',
                            // 'image/jpg',
                            'image/*' //que acepte todo tipo de formato de fotos
                        ])

                        ->required()
                        ->maxSize(2048)//tamaño maximo de al foto
                        ]),
                Section::make('Descripcion detallada')
                    ->schema([
                        RichEditor::make('description') //una tabla donde se pueda editar el texto
                            ->label('Descripcion')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'h1',
                                'h2',
                                'h3',
                                'link', //edita esa misma tabla mostradno una solas opciones
                            ])
                            ->required()
                            ->helperText('Agregar una descripcion') //se añade un micro texto en la secicon

                    ])            
            ]);
    }
}
