<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libros;
use App\Models\Asignaturas;
use App\Models\Reservas;
use App\Models\User;
use App\Models\Entregas;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Asignaturas::factory(10)->create();
        Libros::factory(20)->create();
        User::factory(5)->create();
        Reservas::factory(10)->create();
        Entregas::factory(20)->create();
    }
}
