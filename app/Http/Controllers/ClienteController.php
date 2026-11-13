<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index() {
        return view('clientes.index');
    }

    public function obtenerClientes() {
        $clientes = Cliente::all();
        return response()->json(['data' => $clientes]);
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'teléfono' => 'nullable|string|max:20',
            'correo_electrónico' => 'nullable|email|max:255',
            'es_suscriptor' => 'required|boolean',
            'fecha_vencimiento' => 'nullable|required_if:es_suscriptor,1|date'
        ]);

        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->teléfono = $request->teléfono;
        $cliente->correo_electrónico = $request->correo_electrónico;
        $cliente->es_suscriptor = $request->es_suscriptor;
        $cliente->fecha_vencimiento = $request->es_suscriptor == 1 ? $request->fecha_vencimiento : null;
        $cliente->estado = 1;
        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => '¡Cliente registrado exitosamente!'
        ]);
    }

    public function update(Request $request, $id) {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'teléfono' => 'nullable|string|max:20',
            'correo_electrónico' => 'nullable|email|max:255',
            'es_suscriptor' => 'required|boolean',
            'fecha_vencimiento' => 'nullable|required_if:es_suscriptor,1|date'
        ]);

        $cliente->nombre = $request->nombre;
        $cliente->teléfono = $request->teléfono;
        $cliente->correo_electrónico = $request->correo_electrónico;
        $cliente->es_suscriptor = $request->es_suscriptor;
        $cliente->fecha_vencimiento = $request->es_suscriptor == 1 ? $request->fecha_vencimiento : null;
        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => '¡Datos del cliente actualizados!'
        ]);
    }

    public function cambiarEstado($id) {
        $cliente = Cliente::findOrFail($id);
        $cliente->estado = $cliente->estado == 1 ? 0 : 1;
        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => '¡Estado del cliente actualizado!'
        ]);
    }
}