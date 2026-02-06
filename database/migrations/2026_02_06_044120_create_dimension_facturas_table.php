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
Schema::create('DimensionFacturas', function (Blueprint $table) {
    $table->id('id_factura');
    $table->string('stripe_id', 240)->unique()->nullable();
    $table->string('nombre_emitor', 30);
    $table->string('localizacion', 80);
    $table->timestamp('fecha_emision');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_facturas');
    }
};
