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
Schema::create('DimensionEncargados', function (Blueprint $table) {
    $table->id('id_encargado');
    $table->string('nombres', 30);
    $table->string('apellido_p', 30);
    $table->string('apellido_m', 30);
    $table->char('genero', 1);
    $table->string('telefono', 12);
    $table->string('correo_electronico', 30)->unique();
    $table->string('contrasena', 255);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_encargados');
    }
};
