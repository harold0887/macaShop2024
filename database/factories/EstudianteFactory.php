<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $gender = $this->faker->randomElement($array = array('male', 'female'));
        return [
            'apellidos' => fake('es_ES')->lastName() . " " . fake('es_ES')->lastName(),
            'nombres' => fake('es_ES')->firstName($gender),
            'fecha_nacimiento' => $this->faker->date(),
            'genero' => $gender== "male"? 'M': 'F' ,
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'user_id' => 1,
            'grupo_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
