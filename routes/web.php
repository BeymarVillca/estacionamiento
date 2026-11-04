<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuarioController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/usuarios', [ProductosController::class, 'index'])->name('usuarios.index');

Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
Route::get('/productos/crear', [ProductosController::class, 'index'])->name('productos.create');
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
Route::put('/productos/{id}', [ProductosController::class, 'update'])->name('productos.update');
Route::delete('/productos/{id}', [ProductosController::class, 'destroy'])->name('productos.destroy');