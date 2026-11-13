<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nombre',
        'correo_electrónico',
        'contraseña',
        'id_rol',
        'estado',
    ];

    protected $hidden = [
        'contraseña',
    ];

    // Especificamos que la columna de contraseña se llama 'contraseña'
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    // =======================================
    // Relación: Un usuario pertenece a un Rol
    // =======================================
    public function rol()
    {
        return $this->belongsTo(Role::class, 'id_rol');
    }
}