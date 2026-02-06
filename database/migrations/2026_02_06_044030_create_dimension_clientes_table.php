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
    Schema::create('DimensionClientes', function (Blueprint $table) {
        $table->id('id_cliente');
        $table->string('nombres', 30);
        $table->string('apellido_p', 20);
        $table->string('apellido_m', 20)->nullable();
        $table->char('genero', 1)->nullable();
        $table->string('telefono', 12)->nullable();
        $table->string('telefono_fijo', 12)->nullable();
        $table->string('correo_electronico', 30)->unique();
        $table->integer('cp');
        $table->string('domicilio', 80);
        $table->string('referencias', 50)->nullable();
        $table->string('contrasena', 255);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_clientes');
    }
};
