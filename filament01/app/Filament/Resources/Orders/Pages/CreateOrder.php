<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Inventory;
use App\Models\Product;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateOrder extends CreateRecord
{
    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = Auth::id();

    // Recalcular total en backend (seguridad)
    $total = 0;

    foreach ($data['orderProducts'] ?? [] as $item) {
        $product = Product::find($item['product_id']);

        if ($product) {
            $total += $item['quantity'] * $product->price;
        }
    }

    $data['total'] = $total;

    return $data;
}


    protected function afterCreate(): void
    {
        DB::transaction(function () {
            $this->record->load('orderProducts');

            foreach ($this->record->orderProducts as $pivot) {
                Inventory::query()
                    ->where('warehouse_id', $this->record->warehouse_id)
                    ->where('product_id', $pivot->product_id)
                    ->decrement('quantity', $pivot->quantity);
            }
        });
    }
}
