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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->foreignId('id_suscripcion')->constrained('suscripciones');

            $table->integer('monto');
            $table->string('moneda')->default('ARS');

            $table->string('proveedor'); // stripe, mp
            $table->string('referencia')->nullable();

            $table->enum('estado', ['pendiente', 'pagado', 'fallido']);

            $table->timestamp('pagado_en')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
