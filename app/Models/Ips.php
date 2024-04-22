<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ips extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'ips';
    //relacion con usuarios, retorna el usuario al que pertenece la orden
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
