<?php

namespace Database\Factories;

use App\Models\Reservas;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entregas>
 */
class EntregasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha_entrega' => $this -> faker -> date(),
            'fecha_devolucion' => $this -> faker -> date(),
            'estado' => $this -> faker -> randomKey([
                'No entregado' => 1, 'Entregado' => 2, 'Devuelto' => 3
            ]),
            'reserva_id' => Reservas::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'demora' => $this -> faker -> randomNumber(1, true),
        ];
    }
}
