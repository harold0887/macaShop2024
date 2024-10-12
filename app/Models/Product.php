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
    return $this->belongsToMany(Order::class, 'order_details', 'product_id', 'order_id')->orderByPivot('created_at', 'desc');
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
    return $this->hasMany(Comment::class)->orderBy('created_at', 'desc')->where('status', true);
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

  //Relacion con detalle de categorias, muchos a muchos tabla intermedia new
  public function category_product(): HasMany
  {
    return $this->hasMany(Category_Product::class, 'product_id', 'id');
  }

  public function scopeFilter($query, $filters)
  {
    $query->when($filters['categorias'] ?? null, function ($query, $categorias) {
      $query->whereHas('category_product', function ($query) use ($categorias) {
        $query->whereIn('category_id', $categorias);
      });
    })->when($filters['grados'] ?? null, function ($query, $grados) {
      $query->whereHas('grado', function ($query) use ($grados) {
        $query->whereIn('id', $grados);
      });
    })

      ->when($filters['search'] ?? null, function ($query, $search) {
        $query->where('title', 'like', '%' . $search . '%')
          ->orWhere('information', 'like', '%' . $search . '%');
      })
      ->where('price', '>', 0)
      ->where('status',  true)
      ->orderBy('title', 'asc')
      ->whereNotIn('title', ['newsDesktop', 'newsMobile']);
  }
}
