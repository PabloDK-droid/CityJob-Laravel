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
Schema::create('DimensionContrataciones', function (Blueprint $table) {
    $table->id('id_contratacion');
    $table->foreignId('id_cliente')->constrained('DimensionClientes', 'id_cliente');
    $table->foreignId('id_profesionista')->constrained('DimensionProfesionistas', 'id_profesionista');
    $table->foreignId('id_servicio')->constrained('DimensionServicios', 'id_servicio');
    $table->string('nombres_emitor', 30);
    $table->boolean('estado_emitor');
    $table->string('localizacion', 80);
    $table->timestamp('fecha_realizacion');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_contrataciones');
    }
};
