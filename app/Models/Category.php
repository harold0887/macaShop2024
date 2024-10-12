<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];


    //Relacion muchos a muchos con productos
    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    //Relacion con detalle de productos, muchos a muchos tabla intermedia new
    public function productsAll(): HasMany
    {
        return $this->hasMany(Category_Product::class, 'category_id')

            ->whereHas('products', function ($query) {
                $query->where('price', '>', 0)
                    ->where('status',  true)
                    ->orderBy('title', 'asc')
                    ->whereNotIn('title', ['newsDesktop', 'newsMobile']);;
            });
    }
}
