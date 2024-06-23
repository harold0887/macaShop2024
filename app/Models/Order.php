<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    //relacion con usuarios, retorna el usuario al que pertenece la orden
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    //Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details');
    }
    //Relacion muchos a muchos paquetes
    public function Packages()
    {
        return $this->belongsToMany(Package::class, 'order_details');
    }

    //Relacion muchos a muchos membresias
    public function memberships()
    {
        return $this->belongsToMany(Membership::class, 'order_details');
    }

    //Relacion con detalle de orden, retorna las ventas del producto
    public function sales(): HasMany
    {
        return $this->hasMany(Order_Details::class, 'order_id', 'id');
    }


    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('payment_id', 'like', '%' . $search . '%')
                ->orWhere('order_id', 'like', '%' . $search . '%')
                ->orWhere('contacto', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('email', 'like', '%' . trim($search) . '%')
                        ->orWhere('facebook', 'like', '%' . $search . '%')
                        ->orWhere('whatsapp', 'like', '%' . $search . '%')
                        ->orWhere('comment', 'like', '%' . trim($search) . '%');
                });
        })->when($filters['fromDate'] ?? null, function ($query, $fromDate) {
            $query->where('created_at', '>=', $fromDate . " 00:00:00");
        })->when($filters['toDate'] ?? null, function ($query, $toDate) {
            $query->where('created_at', '<=', $toDate . " 23:59:59");
        })
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            });
    }
}
