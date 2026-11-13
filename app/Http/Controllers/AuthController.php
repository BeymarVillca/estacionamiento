<?php

// =======================================================
// Controlador de Autenticación para el Sistema de Estacionamiento
// =======================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // =======================================
    // Muestra la vista del Login con diseño futurista
    // =======================================
    public function showLogin() {
        return view('auth.login');
    }

    // =======================================
    // Procesa el inicio de sesión por AJAX
    // =======================================
    public function login(Request $request) {
        $request->validate([
            'correo_electrónico' => 'required|email',
            'contraseña' => 'required'
        ]);

        $credentials = [
            'email' => $request->correo_electrónico, // Mapeo para Auth si usas email o ajustar según campo
            'password' => $request->contraseña
        ];

        // Verificación manual adaptada a nuestra columna 'correo_electrónico' y 'contraseña'
        $user = User::where('correo_electrónico', $request->correo_electrónico)->first();

        if ($user && Hash::check($request->contraseña, $user->contraseña)) {
            if ($user->estado == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tu cuenta está desactivada. Contacta al administrador.'
                ], 401);
            }

            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => '¡Bienvenido al sistema, ' . $user->nombre . '!',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas. Verifica tus datos.'
        ], 401);
    }

    // =======================================
    // Cierra la sesión del sistema
    // =======================================
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}