<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'status' => 'Asistencia',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Status::create([
            'status' => 'Falta',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Status::create([
            'status' => 'Retardo',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Status::create([
            'status' => 'Falta justificada',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Status::create([
            'status' => 'Sin registro',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
