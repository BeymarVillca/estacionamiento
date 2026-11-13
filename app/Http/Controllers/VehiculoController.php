<?php

// =======================================================
// Controlador para la Gestión de Vehículos
// =======================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Cliente;
use App\Models\TipoVehiculo;

class VehiculoController extends Controller
{
    // Muestra la vista principal
    public function index() {
        $clientes = Cliente::where('estado', 1)->get();
        $tipos = TipoVehiculo::all();
        return view('vehiculos.index', compact('clientes', 'tipos'));
    }

    // Devuelve los datos en JSON para DataTables
    public function obtenerVehiculos() {
        $vehiculos = Vehiculo::with(['cliente', 'tipoVehiculo'])->get();
        return response()->json(['data' => $vehiculos]);
    }

    // Almacena un nuevo vehículo
    public function store(Request $request) {
        $request->validate([
            'placa' => 'required|string|max:20|unique:vehículos,placa',
            'id_cliente' => 'nullable|exists:clientes,id',
            'id_tipo_vehículo' => 'required|exists:tipos_vehiculo,id',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'color' => 'required|string|max:30',
        ]);

        $vehiculo = new Vehiculo();
        $vehiculo->placa = strtoupper($request->placa);
        $vehiculo->id_cliente = $request->id_cliente;
        $vehiculo->id_tipo_vehículo = $request->id_tipo_vehículo;
        $vehiculo->marca = $request->marca;
        $vehiculo->modelo = $request->modelo;
        $vehiculo->color = $request->color;
        $vehiculo->estado = 1;
        $vehiculo->save();

        return response()->json([
            'success' => true,
            'message' => '¡Vehículo registrado exitosamente!'
        ]);
    }

    // Actualiza el vehículo
    public function update(Request $request, $id) {
        $vehiculo = Vehiculo::findOrFail($id);

        $request->validate([
            'placa' => 'required|string|max:20|unique:vehículos,placa,' . $id,
            'id_cliente' => 'nullable|exists:clientes,id',
            'id_tipo_vehículo' => 'required|exists:tipos_vehiculo,id',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'color' => 'required|string|max:30',
        ]);

        $vehiculo->placa = strtoupper($request->placa);
        $vehiculo->id_cliente = $request->id_cliente;
        $vehiculo->id_tipo_vehículo = $request->id_tipo_vehículo;
        $vehiculo->marca = $request->marca;
        $vehiculo->modelo = $request->modelo;
        $vehiculo->color = $request->color;
        $vehiculo->save();

        return response()->json([
            'success' => true,
            'message' => '¡Datos del vehículo actualizados!'
        ]);
    }

    // Cambia el estado del vehículo (Activo / Inactivo)
    public function cambiarEstado($id) {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->estado = $vehiculo->estado == 1 ? 0 : 1;
        $vehiculo->save();

        return response()->json([
            'success' => true,
            'message' => '¡Estado del vehículo actualizado!'
        ]);
    }
}