<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grupo::create([
            'escuela' => 'Colegio Boston',
            'grado_grupo' => 'Cuarto grado',
            'ciclo_escolar' => '2023-2024',
            'materia' => 'Educación Financiera',
            'maestro' => 'Jorge Alberto Ramos',
            'color' => 'rose',
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
