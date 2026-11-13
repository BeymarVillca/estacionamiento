<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // =======================================
        // Tabla de Usuarios del Sistema
        // =======================================
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('correo_electrónico')->unique();
            $table->string('contraseña');
            $table->foreignId('id_rol')->constrained('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('estado')->default(1); // 1 = Activo, 0 = Inactivo (Requerimiento: No eliminar, solo desactivar)
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};