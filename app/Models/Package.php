<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Order_Details;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    //Relacion muchos a muchos con productos
    public function products()
    {
        return $this->belongsToMany('App\Models\Product')
            ->orderBy('title', 'asc');
    }




    //Relacion con ventas, retorna las ventas del producto
    public function salesDay(): HasMany
    {
        return $this->hasMany(Order_Details::class, 'package_id', 'id')->whereBetween('created_at', [now()->format('Y-m-d') . " 00:00:00", now()->format('Y-m-d') . " 23:59:59"]);
    }


    //nuevas relacions doc laravel

    //Relacion muchos a muchos con Order
    public function  orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_details', 'package_id', 'order_id');
    }



    //Relacion con detalle de orden, retorna las ventas del producto
    public function sales(): HasMany
    {
        return $this->hasMany(Order_Details::class, 'package_id', 'id');
    }
}
