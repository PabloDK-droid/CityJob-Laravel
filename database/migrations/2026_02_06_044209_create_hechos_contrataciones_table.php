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
Schema::create('HechosContrataciones', function (Blueprint $table) {
    $table->id('id_hecho');
    $table->foreignId('id_cliente')->constrained('DimensionClientes', 'id_cliente');
    $table->foreignId('id_profesionista')->constrained('DimensionProfesionistas', 'id_profesionista');
    $table->foreignId('id_encargado')->constrained('DimensionEncargados', 'id_encargado');
    $table->foreignId('id_administrador')->constrained('DimensionAdministradores', 'id_administrador');
    $table->foreignId('id_servicio')->constrained('DimensionServicios', 'id_servicio');
    $table->foreignId('id_contratacion')->constrained('DimensionContrataciones', 'id_contratacion');
    $table->foreignId('id_factura')->constrained('DimensionFacturas', 'id_factura');
    $table->float('monto_total');
    $table->float('comision_plataforma');
    $table->integer('duracion_servicio_minutos');
    $table->timestamp('fecha_registro');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hechos_contrataciones');
    }
};
