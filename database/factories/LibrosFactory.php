<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Asignaturas;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libros>
 */
class LibrosFactory extends Factory
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
            'codigo' => $this -> faker -> regexify('[A-Z]{4}-[0-9]{4}'),
            'titulo' => $this -> faker -> sentence(3),
            'autor' => $this -> faker -> name($gender = 'male'|'female'),
            'year' => $this -> faker -> year($max = 'now'),
            'mueble' => $this -> faker -> regexify('[A-Z]{1}[0-9]{2}'),
            'observacion' => $this -> faker -> randomKey(['C' => 1, 'O' => 2]),
            'disponibilidad' => $this -> faker -> boolean(),
            'asignatura_id' => Asignaturas::inRandomOrder()->first()->id,
        ];
    }
}
