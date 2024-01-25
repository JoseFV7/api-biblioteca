<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Libros;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservas>
 */
class ReservasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'alumno_id' => User::inRandomOrder()->first()->id,
            'libro_id' => Libros::inRandomOrder()->first()->id,
            'estado' => $this -> faker -> randomKey([
                'Pendiente' => 1, 'Aprobado' => 2, 'Rechazado' => 3
            ]),
            'dias_prestamo' => fake()->randomNumber(1,true),
        ];
    }
}
