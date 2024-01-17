<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuarios;
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
            'fecha_entrega' => date($format = 'Y-m-d'),
            'fecha_devolucion' => date($format = 'Y-m-d'),
            'alumno_id' => Usuarios::inRandomOrder()->first()->id,
            'libro_id' => Libros::inRandomOrder()->first()->id,
        ];
    }
}
