<?php

namespace App\Filament\Resources\Customers\Pages;

use App\Filament\Resources\Customers\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getRedirectUrl(): string // aqui redirige despues de crear un nuevo registro
    {
        return $this->getResource()::getUrl('index'); //se redirige a la tabla de view 
    }
}
