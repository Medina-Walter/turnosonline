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
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->foreignId('id_plan')->constrained('planes');

            $table->enum('estado', [
                'pendiente',
                'trial',
                'activa',
                'cancelada',
                'vencida'
            ])->default('pendiente');


            $table->date('inicia_en');
            $table->date('vence_en')->nullable();
            $table->date('trial_hasta')->nullable();
            $table->string('mp_id')->nullable();

            $table->string('mp_status')->nullable();

            $table->boolean('renovacion_automatica')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripciones');
    }
};
