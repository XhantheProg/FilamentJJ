<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Filament\Resources\Customers\Pages\ListCustomers;
use App\Filament\Resources\Customers\Pages\ViewCustomer;
use App\Filament\Resources\Customers\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Resources\Customers\Tables\CustomersTable;
use App\Models\Customer;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CustomerResource extends Resource
{

    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $label = 'Cliente';
    protected static ?string $pluralLabel = 'Clientes';

    protected static ?string $slug = 'clientes';
    protected static string|UnitEnum|null $navigationGroup = 'CRM';

    protected static ?string $model = Customer::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'Customer';

    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
    }


    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informacion del Ciente')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre Completo')
                            ->icon('heroicon-o-user'),

                         TextEntry::make('email')
                            ->label('Correo') 
                            ->icon('heroicon-o-envelope'),

                        TextEntry::make('phone')
                            ->label('Telefono') 
                            ->icon('heroicon-o-phone'),
                            
                         TextEntry::make('nit')
                            ->label('Facturacion') 
                            ->icon('heroicon-o-home'),   
                            
                            
                    ])  
            ]);
    }
    public static function getRelations(): array
    {
        return [
            OrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomers::route('/'),
            // 'create' => CreateCustomer::route('/create'),
            'edit' => EditCustomer::route('/{record}/edit'),
            'view' => ViewCustomer::route('/{record}'),
        ];
    }
}