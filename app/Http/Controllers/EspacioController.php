<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspacioEstacionamiento;
use App\Models\TipoVehiculo;

class EspacioController extends Controller
{
    // Muestra la vista principal de celdas
    public function index() {
        $tipos = TipoVehiculo::all();
        return view('espacios.index', compact('tipos'));
    }

    // Devuelve los datos en JSON para DataTables
    public function obtenerEspacios() {
        $espacios = EspacioEstacionamiento::with('tipoVehiculo')->get();
        return response()->json(['data' => $espacios]);
    }

    // Almacena una nueva celda / espacio
    public function store(Request $request) {
        $request->validate([
            'código' => 'required|string|max:20|unique:espacios_estacionamiento,código',
            'id_tipo_vehículo' => 'required|exists:tipos_vehiculo,id',
            'estado_ocupacion' => 'required|integer|in:0,1,2',
        ]);

        $espacio = new EspacioEstacionamiento();
        $espacio->código = strtoupper($request->código);
        $espacio->id_tipo_vehículo = $request->id_tipo_vehículo;
        $espacio->estado_ocupacion = $request->estado_ocupacion;
        $espacio->estado = 1;
        $espacio->save();

        return response()->json([
            'success' => true,
            'message' => '¡Celda registrada exitosamente!'
        ]);
    }

    // Actualiza la celda existente
    public function update(Request $request, $id) {
        $espacio = EspacioEstacionamiento::findOrFail($id);

        $request->validate([
            'código' => 'required|string|max:20|unique:espacios_estacionamiento,código,' . $id,
            'id_tipo_vehículo' => 'required|exists:tipos_vehiculo,id',
            'estado_ocupacion' => 'required|integer|in:0,1,2',
        ]);

        $espacio->código = strtoupper($request->código);
        $espacio->id_tipo_vehículo = $request->id_tipo_vehículo;
        $espacio->estado_ocupacion = $request->estado_ocupacion;
        $espacio->save();

        return response()->json([
            'success' => true,
            'message' => '¡Datos de la celda actualizados!'
        ]);
    }

    // Cambia el estado lógico (Activo / Inactivo)
    public function cambiarEstado($id) {
        $espacio = EspacioEstacionamiento::findOrFail($id);
        $espacio->estado = $espacio->estado == 1 ? 0 : 1;
        $espacio->save();

        return response()->json([
            'success' => true,
            'message' => '¡Estado de la celda actualizado!'
        ]);
    }
}