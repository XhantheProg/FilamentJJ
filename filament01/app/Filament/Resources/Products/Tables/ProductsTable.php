<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Imagen')
                    ->disk('public')
                    // ->imageHeight(50)
                    ->imageSize(50),

                TextColumn::make('code')
                    ->label('Codigo')
                    ->searchable()
                    ->sortable()    
                    ->badge()    
                    ->color('success'),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()    
                    ->sortable(),
                    
                TextColumn::make('category.name') //tiene que escribirse asi para que muestre especificamente que parte de la categoria mostrar
                    ->badge()
                    ->color('success')
                    ->searchable()
                    ->sortable()
                    ->label('Categoria'),
                    
                TextColumn::make('summary')
                    ->label('Resumen'),

                TextColumn::make('is_active')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(bool $state)=> $state ? 'success':'danger') //closure funciones sin nombre
                    ->formatStateUsing(fn(bool $state)=> $state ? 'Activo':'Inactivo'),

                TextColumn::make('price')
                    ->label('Precio')
                    ->money('USD',true)//muestra la moneda
                    ->sortable(),
                    
                TextColumn::make('created_at') //created_at muestra la fecha que fue creado
                ->label('Creado')
                ->date()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault:true), //por defectono muestra las fechas
                
                
                TextColumn::make('updated_at') //created_at muestra la fecha que fue creado
                ->label('Actualizado')
                ->date()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault:true), 
                  
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
