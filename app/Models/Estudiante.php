<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudiante extends Model
{
    use HasFactory;
    protected $guarded = [];

    //Relacion muchos a muchos
    public function dias()
    {
        return $this->belongsToMany(Dia::class, 'dia_estudiante');
    }

    //Relacion con grupo, retorna el grupo al que pertenece
    public function grupo()
    {
        return $this->belongsToMany(Grupo::class);
    }

    //relacion con asistencias, retorna las asitencias  de un estudiante
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
