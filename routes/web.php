<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\ReporteController;


// =======================================
// Rutas Públicas de Autenticación
// =======================================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================================
// Rutas Protegidas del Sistema (Requieren Login)
// =======================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Módulo de Seguridad y Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/obtener', [UsuarioController::class, 'obtenerUsuarios'])->name('usuarios.obtener');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::post('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.estado');

    // Módulo de Clientes y Abonados
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/obtener', [ClienteController::class, 'obtenerClientes'])->name('clientes.obtener');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::post('/clientes/{id}/estado', [ClienteController::class, 'cambiarEstado'])->name('clientes.estado');

    // =======================================
    // Rutas del Módulo de Vehículos
    // =======================================
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/obtener', [VehiculoController::class, 'obtenerVehiculos'])->name('vehiculos.obtener');
    Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
    Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('vehiculos.update');
    Route::post('/vehiculos/{id}/estado', [VehiculoController::class, 'cambiarEstado'])->name('vehiculos.estado');

    // =======================================
    // Rutas del Módulo de Celdas / Espacios
    // =======================================
    Route::get('/espacios', [EspacioController::class, 'index'])->name('espacios.index');
    Route::get('/espacios/obtener', [EspacioController::class, 'obtenerEspacios'])->name('espacios.obtener');
    Route::post('/espacios', [EspacioController::class, 'store'])->name('espacios.store');
    Route::put('/espacios/{id}', [EspacioController::class, 'update'])->name('espacios.update');
    Route::post('/espacios/{id}/estado', [EspacioController::class, 'cambiarEstado'])->name('espacios.estado');

    // =======================================
    // Rutas del Módulo de Boletos (Entradas y Salidas)
    // =======================================
    Route::get('/boletos', [BoletoController::class, 'index'])->name('boletos.index');
    Route::get('/boletos/obtener', [BoletoController::class, 'obtenerBoletos'])->name('boletos.obtener');
    Route::post('/boletos/entrada', [BoletoController::class, 'registrarEntrada'])->name('boletos.entrada');
    Route::post('/boletos/{id}/salida', [BoletoController::class, 'registrarSalida'])->name('boletos.salida');

    // =======================================
    // Rutas del Módulo de Caja y Facturación
    // =======================================
    Route::get('/caja', [CajaController::class, 'index'])->name('caja.index');
    Route::get('/caja/obtener', [CajaController::class, 'obtenerHistorialCobros'])->name('caja.obtener');

    // =======================================
    // Rutas del Módulo de Reportes
    // =======================================
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/generar', [ReporteController::class, 'generar'])->name('reportes.generar');

});