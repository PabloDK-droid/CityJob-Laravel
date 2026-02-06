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
Schema::create('DimensionCalificaciones', function (Blueprint $table) {
    $table->id('id_calificaciones');
    $table->foreignId('id_cliente')->constrained('DimensionClientes', 'id_cliente');
    $table->foreignId('id_profesionista')->constrained('DimensionProfesionistas', 'id_profesionista');
    $table->float('calificacion');
    $table->integer('total_calif');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_calificaciones');
    }
};
