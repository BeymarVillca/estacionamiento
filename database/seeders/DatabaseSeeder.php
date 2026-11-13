<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =======================================
        // 1. Insertar Roles del Sistema
        // =======================================
        $rolAdmin = DB::table('roles')->insertGetId(['nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()]);
        $rolOperador = DB::table('roles')->insertGetId(['nombre' => 'Operador', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('roles')->insert(['nombre' => 'Supervisor', 'created_at' => now(), 'updated_at' => now()]);

        // =======================================
        // 2. Insertar Usuario Administrador por Defecto
        // =======================================
        DB::table('users')->insert([
            'nombre' => 'Administrador General',
            'correo_electrónico' => 'admin@estacionamiento.com',
            'contraseña' => Hash::make('12345678'), // Contraseña por defecto
            'id_rol' => $rolAdmin,
            'estado' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // =======================================
        // 3. Insertar Tipos de Vehículo
        // =======================================
        DB::table('tipos_vehiculo')->insert([
            ['nombre' => 'Auto', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Moto', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Camioneta', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =======================================
        // 4. Insertar Métodos de Pago
        // =======================================
        DB::table('métodos_pago')->insert([
            ['nombre' => 'Efectivo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'QR', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}