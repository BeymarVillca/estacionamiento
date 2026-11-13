<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // =======================================
        // Tabla de Clientes / Abonados
        // =======================================
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('teléfono')->nullable();
            $table->string('correo_electrónico')->nullable();
            $table->boolean('es_suscriptor')->default(0); // 0 = Regular, 1 = Mensualidad/Convenio
            $table->date('fecha_vencimiento')->nullable();
            $table->boolean('estado')->default(1); // 1 = Activo, 0 = Inactivo
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('clientes');
    }
};