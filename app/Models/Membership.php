<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Membership extends Model
{
    use HasFactory;
    protected $guarded = [];

    //Relacion muchos a muchos con productos
    public function products()
    {
        return $this->belongsToMany('App\Models\Product')
            ->whereNotIn('title', ['newsDesktop', 'newsMobile'])
            ->orderBy('title', 'asc');
    }
    //Relacion muchos a muchos con productos para mostar en membresía
    public function productss()
    {
        return $this->belongsToMany('App\Models\Product')
            ->whereNotIn('title', ['newsDesktop', 'newsMobile']);
           
    }


    //nuevas relacions doc laravel

    //Relacion muchos a muchos con Order
    public function  orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_details', 'membership_id', 'order_id');
    }




    //Relacion con detalle de orden, retorna las ventas del producto
    public function sales(): HasMany
    {
        return $this->hasMany(Order_Details::class, 'membership_id', 'id');
    }
}
