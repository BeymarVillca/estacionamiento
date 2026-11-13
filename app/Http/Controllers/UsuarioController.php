<?php

// =======================================================
// Controlador para la Gestión de Usuarios y Accesos
// =======================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // =======================================
    // Muestra la vista principal del módulo de usuarios
    // =======================================
    public function index() {
        $roles = Role::all();
        return view('usuarios.index', compact('roles'));
    }

    // =======================================
    // Devuelve los datos en formato JSON para DataTables
    // =======================================
    public function obtenerUsuarios() {
        $usuarios = User::with('rol')->get();
        return response()->json(['data' => $usuarios]);
    }

    // =======================================
    // Almacena un nuevo usuario en la base de datos
    // =======================================
    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electrónico' => 'required|email|unique:users,correo_electrónico',
            'contraseña' => 'required|min:6',
            'id_rol' => 'required|exists:roles,id'
        ]);

        $usuario = new User();
        $usuario->nombre = $request->nombre;
        $usuario->correo_electrónico = $request->correo_electrónico;
        $usuario->contraseña = Hash::make($request->contraseña);
        $usuario->id_rol = $request->id_rol;
        $usuario->estado = 1; // Activo por defecto
        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => '¡Usuario registrado exitosamente!'
        ]);
    }

    // =======================================
    // Actualiza los datos de un usuario existente
    // =======================================
    public function update(Request $request, $id) {
        $usuario = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electrónico' => 'required|email|unique:users,correo_electrónico,' . $id,
            'id_rol' => 'required|exists:roles,id'
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo_electrónico = $request->correo_electrónico;
        if($request->filled('contraseña')) {
            $usuario->contraseña = Hash::make($request->contraseña);
        }
        $usuario->id_rol = $request->id_rol;
        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => '¡Usuario actualizado correctamente!'
        ]);
    }

    // =======================================
    // Cambia el estado del usuario (Activar / Desactivar en lugar de eliminar)
    // =======================================
    public function cambiarEstado($id) {
        $usuario = User::findOrFail($id);
        $usuario->estado = $usuario->estado == 1 ? 0 : 1;
        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => '¡Estado del usuario actualizado con éxito!'
        ]);
    }
}