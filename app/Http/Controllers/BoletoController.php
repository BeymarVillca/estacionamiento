<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boleto;
use App\Models\Vehiculo;
use App\Models\EspacioEstacionamiento;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BoletoController extends Controller
{
    // Muestra la vista principal de entradas y salidas
    public function index() {
        $vehiculos = Vehiculo::where('estado', 1)->get();
        // Solo celdas disponibles (estado_ocupacion = 0 y estado activo = 1)
        $espacios = EspacioEstacionamiento::where('estado', 1)->where('estado_ocupacion', 0)->get();
        return view('boletos.index', compact('vehiculos', 'espacios'));
    }

    // Devuelve los boletos activos e historiales en JSON para DataTables
    public function obtenerBoletos() {
        $boletos = Boleto::with(['vehiculo', 'espacio', 'usuarioIngreso'])->get();
        return response()->json(['data' => $boletos]);
    }

    // Registrar Entrada (Check-In)
    public function registrarEntrada(Request $request) {
        $request->validate([
            'id_vehículo' => 'required|exists:vehículos,id',
            'id_espacio' => 'required|exists:espacios_estacionamiento,id',
        ]);

        // Verificar si el vehículo ya tiene un boleto abierto
        $existente = Boleto::where('id_vehículo', $request->id_vehículo)
                           ->where('estado_boleto', 0)
                           ->first();
        if ($existente) {
            return response()->json([
                'success' => false,
                'message' => 'El vehículo ya se encuentra dentro del estacionamiento.'
            ], 422);
        }

        // Crear el boleto
        $boleto = new Boleto();
        $boleto->id_vehículo = $request->id_vehículo;
        $boleto->id_espacio = $request->id_espacio;
        $boleto->id_usuario_ingreso = Auth::id();
        $boleto->fecha_hora_ingreso = Carbon::now();
        $boleto->estado_boleto = 0; // Abierto
        $boleto->save();

        // Ocupar el espacio
        $espacio = EspacioEstacionamiento::findOrFail($request->id_espacio);
        $espacio->estado_ocupacion = 1; // Ocupado
        $espacio->save();

        return response()->json([
            'success' => true,
            'message' => '¡Entrada registrada correctamente!'
        ]);
    }

    // Registrar Salida y Calcular Cobro (Check-Out)
    public function registrarSalida($id) {
        $boleto = Boleto::with(['vehiculo.tipoVehiculo'])->findOrFail($id);

        if ($boleto->estado_boleto == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Este boleto ya fue finalizado.'
            ], 422);
        }

        $ingreso = Carbon::parse($boleto->fecha_hora_ingreso);
        $salida = Carbon::now();
        
        // Calcular horas transcurridas (mínimo 1 hora o fracción)
        $minutos = $ingreso->diffInMinutes($salida);
        $horas = ceil($minutos / 60);
        if ($horas < 1) $horas = 1;

        // Tarifa base por hora (puedes ajustarla según el tipo de vehículo)
        // Por ejemplo: Auto = 10 Bs/hora, Moto = 5 Bs/hora
        $tarifaHora = 10.00; 
        if ($boleto->vehiculo && $boleto->vehiculo->tipoVehiculo) {
            // Si el tipo de vehículo tiene nombre moto, cobramos menos, etc.
            if (stripos($boleto->vehiculo->tipoVehiculo->nombre, 'moto') !== false) {
                $tarifaHora = 5.00;
            }
        }

        $totalPagar = $horas * $tarifaHora;

        // Actualizar boleto
        $boleto->fecha_hora_salida = $salida;
        $boleto->id_usuario_salida = Auth::id();
        $boleto->total_pagado = $totalPagar;
        $boleto->estado_boleto = 1; // Finalizado
        $boleto->save();

        // Liberar el espacio de estacionamiento
        $espacio = EspacioEstacionamiento::findOrFail($boleto->id_espacio);
        $espacio->estado_ocupacion = 0; // Disponible
        $espacio->save();

        return response()->json([
            'success' => true,
            'message' => "¡Salida registrada con éxito! Total a cobrar: $ {$totalPagar} ({$horas} hora(s))"
        ]);
    }
}