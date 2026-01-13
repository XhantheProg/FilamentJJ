<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'slug',
        'summary',
        'description',
        'price',
        'image',
        'is_active',
        'category_id'
    ];

    protected static function booted()
    {
        static::creating(function($category){ //esto es una funcion para crear la funcion de editar
            $category->slug = Str::slug($category->name);
        });
        static::updating(function($category){
            $category->slug = Str::slug($category->name);//esto es una funcion para crear la funcion de borrar
        });
    }

    public function category(){
                return $this-> belongsTo(Category::class);

    }

    public function inventories(): HasMany{ //nombre de la funcion en plural
        return $this-> hasMany(Inventory::class); //relacion de uno a muchos (uno)
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
