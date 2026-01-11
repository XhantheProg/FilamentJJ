<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use function Livewire\str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'summary'
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

    public function products(){
        return $this-> hasMany(Product::class); //asi se relaciona la llave foranea
    }
}
