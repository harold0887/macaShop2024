<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $guarded = [];

    //relacion con estudiantes, retorna los estudiantes de un grado
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'grupo_id')->orderBy('apellidos', 'asc');
    }
}
