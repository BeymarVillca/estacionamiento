<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleto;
use Carbon\Carbon;

class ReporteController extends Controller
{
    // =======================================
    // Muestra la vista principal de Reportes
    // =======================================
    public function index() {
        return view('reportes.index');
    }

    // =======================================
    // Genera datos filtrados para gráficos y tablas
    // =======================================
    public function generar(Request $request) {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->endOfMonth());

        $reportes = Boleto::with(['vehiculo.tipoVehiculo', 'espacio'])
                          ->whereBetween('fecha_hora_ingreso', [$fechaInicio, $fechaFin])
                          ->get();

        return response()->json([
            'success' => true,
            'data' => $reportes
        ]);
    }
}