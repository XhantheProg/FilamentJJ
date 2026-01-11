<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([ //aqui se edita lo ue unicamente la columns
                TextColumn::make('name')
                    ->searchable() //ahora se puede buscar por el nombre una barra de busqueda
                    ->sortable() //ahora se puede ordenar lacolumna nombre de forma asc o dec
                    ->label('Nombre'),
                
                TextColumn::make('slug')
                    ->copyable() //al hacer lcick encima del slug ahora se puede copiar de un click
                    ->badge() //cambia el color a otro formato
                    ->label('Slug'), //respeta los mismos espacios de category
                
                TextColumn::make('summary')
                    ->searchable()
                    ->label('Resumen'), //respeta los mismos espacios de category
            ])
            ->filters([
               
                    //
            ])
            ->recordActions([
                EditAction::make() //aqui importas la funcion de editar
                    ->iconButton(),

                DeleteAction::make()//aqui importas la funcion de borrar
                    ->iconButton(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
