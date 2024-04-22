<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    //relacion con productos, retorna el producto al que pertenece
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //relacion con usuarios, retorna el usarui al que pertenece
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
