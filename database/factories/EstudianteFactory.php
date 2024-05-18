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
        return [
            'apellidos' => $this->faker->lastName()." ". $this->faker->lastName() ,
            'nombres' => $this->faker->firstName('male'|'female'),
            'fecha_nacimiento' => $this->faker->date(),
            'genero' => "M",
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'user_id' => 1,
            'grupo_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
