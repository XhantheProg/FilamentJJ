<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Telefono')
                    ->searchable(),

                TextColumn::make('nit')
                    ->label('NIT')
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label('Estado')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->iconButton(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('¿Estas seguro que deseas eliminar este cliente?')
                    ->modalSubheading('Esta accion no se puede deshacer') //submensaje al apretar borrar
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}