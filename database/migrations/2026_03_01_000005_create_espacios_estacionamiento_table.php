<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // =======================================
        // Tabla de Celdas / Espacios de Estacionamiento
        // =======================================
        Schema::create('espacios_estacionamiento', function (Blueprint $table) {
            $table->id();
            $table->string('piso');
            $table->string('sector');
            $table->string('número');
            $table->boolean('está_ocupado')->default(0); // 0 = Libre, 1 = Ocupado
            $table->boolean('estado')->default(1); // 1 = Activo, 0 = Inactivo
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('espacios_estacionamiento');
    }
};