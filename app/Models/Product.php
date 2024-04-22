<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Grade;
use App\Models\Descarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];




  //nuevas relacions doc laravel

  //Relacion muchos a muchos con Order
  public function  orders(): BelongsToMany
  {
    return $this->belongsToMany(Order::class, 'order_details', 'product_id', 'order_id');
  }

   




  //Relacion con categorias, retorna la categoria a la que pertenece
  public function categorias()
  {
    return $this->belongsToMany('App\Models\Category');
  }
  //Relacion muchos a muchos con membresias
  public function membresias()
  {
    return $this->belongsToMany('App\Models\Membership');
  }

  //Relacion muchos a muchos con paquete
  public function package()
  {
    return $this->belongsToMany(Package::class)->orderBy('name', 'desc');
  }





  //Relacion con detalle de orden, retorna las ventas del producto
  public function sales(): HasMany
  {
    return $this->hasMany(Order_Details::class, 'product_id', 'id');
  }

  //relacion con descargas, retorna las descargas de un producto
  public function descargas()
  {
    return $this->hasMany(Descarga::class, 'id_product');
  }
  //relacion con grados, retorna los grados de un producto
  public function grados()
  {
    return $this->hasMany(Grade::class);
  }
  //relacion con comentarios, retorna los comentarios de un producto
  public function comentarios()
  {
    return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
  }

  //relacion con items, retorna las fotos del producto
  public function items()
  {
    return $this->hasMany(Item::class, 'products_id')->orderBy('created_at', 'desc');
  }





  //relacion con grado, retorna el grado al que pertenece
  public function grado()
  {
    return $this->belongsTo(Grade::class, 'grade');
  }
}
