<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuarios>
 */
class UsuariosFactory extends Factory
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
            'nombre' => $this -> faker -> name(),
            'apellido' => $this -> faker -> name(),
            'codigo' => $this -> faker -> regexify('[A-Z]{3}[0-9]{3}'),
            'dni' => $this -> faker -> randomNumber(8, false),
            'edad' => $this -> faker -> randomNumber(2, false),
            'password' => $this -> faker -> regexify('[a-z]{2}[0-9]{1}')
            // rol"
            // contraseña
        ];
    }
}
