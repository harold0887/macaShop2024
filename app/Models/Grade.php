<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $table = 'degrees';
    protected $guarded = [];

    //relacion con productos, retorna los productos de un grado
    public function products()
    {
        return $this->hasMany(Product::class, 'grade')
            ->where('price', '>', 0)
            ->where('status',  true)
            ->orderBy('title', 'asc')
            ->whereNotIn('title', ['newsDesktop', 'newsMobile']);
    }
}
