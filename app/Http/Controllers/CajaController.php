<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleto;
use Carbon\Carbon;

class CajaController extends Controller
{
    // =======================================
    // Muestra la vista principal de Caja
    // =======================================
    public function index() {
        // Calcular ingresos del día actual
        $ingresosHoy = Boleto::where('estado_boleto', 1)
                            ->whereDate('fecha_hora_salida', Carbon::today())
                            ->sum('total_pagado');

        // Total de boletos cobrados hoy
        $boletosHoy = Boleto::where('estado_boleto', 1)
                            ->whereDate('fecha_hora_salida', Carbon::today())
                            ->count();

        return view('caja.index', compact('ingresosHoy', 'boletosHoy'));
    }

    // =======================================
    // Devuelve el historial de cobros en JSON para DataTables
    // =======================================
    public function obtenerHistorialCobros() {
        $cobros = Boleto::with(['vehiculo', 'espacio'])
                        ->where('estado_boleto', 1)
                        ->orderBy('fecha_hora_salida', 'desc')
                        ->get();
                        
        return response()->json(['data' => $cobros]);
    }
}