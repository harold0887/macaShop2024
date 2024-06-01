<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Asistencia;
use App\Models\Estudiante;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AsistenciaSeeder extends Seeder
{

    public $estudiantes;
    public $dia;
    public $faker;


    public function __construct()
    {
        $this->estudiantes = Estudiante::where('grupo_id', 1)->get();
        $this->dia = Carbon::create(2024, 5, 26, 0);
        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create();
    }



    public function run(): void
    {
        for ($i = 1; $i < 365; $i++) {

            $day = Carbon::create(2023, 8, 28, 0)->addDays($i);

            if ($day->format('l') == 'Saturday' || $day->format('l') == 'Sunday') {
                
            } else {
                foreach ($this->estudiantes as $estudiante) {
                    Asistencia::create([
                        'dia' => $day,
                        'estudiante_id' => $estudiante->id,
                        'status_id'=>$this->chance(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
    function chance()
    {
        //$input=array('1' => 15.3, '2' => 64.7, '3' => 20.0);
        $input=array('1' => 80.0, '2' => 15.3, '3' => 5.0, '4' => 5.0);
        $number = rand(0, array_sum($input) * 10);
       
        $starter = 0;
        foreach ($input as $key => $val) {
            $starter += $val * 10;
           
            if ($number <= $starter) {
                $ret = $key;

                break;
            }
        }

        return $ret;
    }
}
