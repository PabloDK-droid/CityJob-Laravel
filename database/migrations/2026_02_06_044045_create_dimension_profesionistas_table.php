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
    Schema::create('DimensionProfesionistas', function (Blueprint $table) {
        $table->id('id_profesionista');
        $table->string('nombres', 30);
        $table->string('apellido_p', 30);
        $table->string('apellido_m', 30);
        $table->char('genero', 1);
        $table->string('telefono', 12);
        $table->string('correo_electronico', 30)->unique();
        $table->string('nivel_estudios', 30);
        $table->string('especializado', 40);
        $table->float('calificacion_profesionista', 3);
        $table->string('domicilio', 80);
        $table->integer('cp');
        $table->string('contrasena', 255);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_profesionistas');
    }
};
