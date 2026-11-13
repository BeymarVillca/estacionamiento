<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // =======================================
        // Tabla de Métodos de Pago (Efectivo, QR)
        // =======================================
        Schema::create('métodos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // =======================================
        // Tabla Operacional de Boletos (Entradas y Salidas)
        // =======================================
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_vehículo')->constrained('vehículos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('id_espacio_estacionamiento')->constrained('espacios_estacionamiento')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('id_usuario')->constrained('users')->onUpdate('cascade')->onDelete('restrict'); // Operador que atiende
            $table->dateTime('hora_entrada');
            $table->dateTime('hora_salida')->nullable();
            $table->integer('total_tiempo_minutos')->nullable();
            $table->foreignId('id_método_pago')->nullable()->constrained('métodos_pago')->onUpdate('cascade')->onDelete('set null');
            $table->decimal('monto_total', 10, 2)->nullable();
            $table->boolean('está_pagado')->default(0); // 0 = Pendiente, 1 = Pagado
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('boletos');
        Schema::dropIfExists('métodos_pago');
    }
};