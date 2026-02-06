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
Schema::create('DimensionHistorial', function (Blueprint $table) {
    $table->id('id_historial');
    $table->foreignId('id_factura')->constrained('DimensionFacturas', 'id_factura');
    $table->foreignId('id_contratacion')->constrained('DimensionContrataciones', 'id_contratacion');
    $table->timestamp('fecha_factura');
    $table->float('monto');
    $table->time('hora');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_historial');
    }
};
