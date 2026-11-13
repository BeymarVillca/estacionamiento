<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspacioEstacionamiento extends Model
{
    use HasFactory;

    protected $table = 'espacios_estacionamiento';

    protected $fillable = [
        'código',
        'id_tipo_vehículo',
        'estado_ocupacion', // 0: Disponible, 1: Ocupado, 2: Mantenimiento
        'estado',           // 0: Inactivo, 1: Activo (Soft-state)
    ];

    // Relación con el tipo de vehículo permitido en la celda
    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class, 'id_tipo_vehículo');
    }
}