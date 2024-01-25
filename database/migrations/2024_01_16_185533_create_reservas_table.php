<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libro_id');
            $table->foreign('libro_id')->references('id')->on('libros');
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('users');
            $table->string('estado', 10);
            $table->smallInteger('dias_prestamo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
