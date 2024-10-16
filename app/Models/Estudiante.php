<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    // //Relacion con grupo, retorna el grupo al que pertenece
    // public function grupo()
    // {
    //     return $this->belongsToMany(Grupo::class);
    // }

    //relacion con asistencias, retorna las asitencias  de un estudiante
    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }

    //Relacion con tags, retorna los tags
    public function tags(): HasMany
    {
        return $this->hasMany(Estudiante_Tag::class);
    }
    //Relacion con grupos, retorna el grupo al que pertenece

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }


    public function scopeFilter($query, $filters)
    {
        $query->when($filters['yearSelect1'] ?? null, function ($query, $yearSelect) {
            $query->whereHas('asistencias', function ($query) use ($yearSelect) {
                $query->whereYear('dia', $yearSelect);
            });
        })->when($filters['monthSelect1'] ?? null, function ($query, $monthSelect1) {
            $query->whereHas('asistencias', function ($query) use ($monthSelect1) {
                $query->whereMonth('dia', $monthSelect1);
            });
        });
    }
}
