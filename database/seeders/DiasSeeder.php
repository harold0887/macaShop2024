<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Dia;
use App\Models\Grupo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        for ($i=1; $i < 365; $i++) { 
            Dia::create([
                'dia' => Carbon::create(2023, 1, 1, 0)->addDays($i),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

       
        
    }
}
