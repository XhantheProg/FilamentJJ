<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
    ];

    public function product(): BelongsTo //ralacion de muchos a uno (muchos)
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo //ralacion de muchos a uno (muchos)
    {
        return $this->belongsTo(Warehouse::class);
    }
}
