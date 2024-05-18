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
            'cliclo_escolar' => '2022-2023',
            'materia' => 'Lenguna Materna',
            'maestro' => 'Jorge Alberto Ramos',
            'color' => 'primary',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
