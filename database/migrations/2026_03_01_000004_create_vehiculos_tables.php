<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // =======================================
        // Tabla de Tipos de Vehículo (Auto, Moto, Camioneta)
        // =======================================
        Schema::create('tipos_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // =======================================
        // Tabla de Vehículos
        // =======================================
        Schema::create('vehículos', function (Blueprint $table) {
            $table->id();
            $table->string('placa')->unique();
            $table->foreignId('id_cliente')->nullable()->constrained('clientes')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('id_tipo_vehículo')->constrained('tipos_vehiculo')->onUpdate('cascade')->onDelete('restrict');
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->boolean('estado')->default(1); // 1 = Activo, 0 = Inactivo
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('vehículos');
        Schema::dropIfExists('tipos_vehiculo');
    }
};