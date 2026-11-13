<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

    protected $table = 'boletos';

    protected $fillable = [
        'id_vehículo',
        'id_espacio',
        'id_usuario_ingreso',
        'id_usuario_salida',
        'fecha_hora_ingreso',
        'fecha_hora_salida',
        'total_pagado',
        'estado_boleto', // 0: Abierto (En estacionamiento), 1: Finalizado / Pagado
    ];

    // Relaciones
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehículo');
    }

    public function espacio()
    {
        return $this->belongsTo(EspacioEstacionamiento::class, 'id_espacio');
    }

    public function usuarioIngreso()
    {
        return $this->belongsTo(User::class, 'id_usuario_ingreso');
    }
}