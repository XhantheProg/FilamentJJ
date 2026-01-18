<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use App\Filament\Resources\Customers\CustomerResource;
use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $relatedResource = CustomerResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Compras del cliente')
            ->headerActions([
                CreateAction::make(),
            ])

            ->columns([
                TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('warehouse.name')
                    ->label('Almacen')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('total')
                    ->label('Total')
                    ->money('usd', true)
                    ->sortable()
                    ->searchable()
            ])
            
            ->actions([
                Action::make('view')
                    ->label('Ver')
                    ->url(fn($record) => OrderResource::getUrl('edit', ['record' => $record->id]))
                    ->icon('heroicon-o-eye')
                    ->openUrlInNewTab()
            ]);
    }
}
