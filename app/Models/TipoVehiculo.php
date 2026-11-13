<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    use HasFactory;

    // Indicamos explícitamente el nombre de la tabla en la base de datos
    protected $table = 'tipos_vehiculo';

    protected $fillable = [
        'nombre',
    ];

    // =======================================
    // Relación: Un tipo de vehículo tiene muchos vehículos
    // =======================================
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_tipo_vehículo');
    }
}