<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_Details extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'order_details';


    //Relacion muchos a muchos con productos
    // public function products()
    // {
    //     return $this->belongsToMany('App\Models\Product')
    //         ->orderBy('title', 'asc');
    // }


    //recupera la orden a la que pertenece
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    //recupera el paquete a la que pertenece
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    //recupera el producto a la que pertenece
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    //recupera la membresía a la que pertenece
    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['fromDate'] ?? null, function ($query, $fromDate) {
            $query->where('created_at', '>=', $fromDate);
        })->when($filters['toDate'] ?? null, function ($query, $toDate) {
            $query->where('created_at', '<=', $toDate);
        });
    }
}
