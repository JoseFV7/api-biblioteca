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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20);
            $table->string('titulo', 150);
            $table->string('autor', 30);
            $table->smallInteger('year');
            $table->string('mueble', 3);
            $table->char('observacion', 1);
            $table->string('portada',300)->nullable();
            $table->boolean('disponibilidad')->nullable()->default(true);
            $table->unsignedBigInteger('asignatura_id');
            $table->smallInteger('stock');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
