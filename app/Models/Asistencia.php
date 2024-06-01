<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $guarded = [];
     //Relacion con estudiante, retorna el estudiante al que pertenece
 
     public function estudiante()
     {
         return $this->belongsTo(Estudiante::class);
     }
}
