<?php

namespace Database\Seeders;

use App\Models\Condicion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CondicionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Condicion::create([
            'condicion' => 'Ninguna',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Trastorno del espectro autista',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Síndrome de Asperger',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Trastorno de déficit de atención e hiperactividad',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Trastorno mixto del desarrollo del aprendizaje',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'trastorno postural',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Síndrome de Tourette',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Asma',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Dislexia',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discalculia',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Disgrafia',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Epilepsia',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad intelectual leve',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad intelectual moderada',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad intelectual grave',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad intelectual profunda',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Problemas de conducta',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad motriz',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad auditiva',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad visual',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Condicion::create([
            'condicion' => 'Discapacidad visceral',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
