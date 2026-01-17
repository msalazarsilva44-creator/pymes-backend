<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    /**
     * Login Web (crea sesión web + token API)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta ha sido suspendida. Contacta al administrador.'
            ], 403);
        }

        // Crear sesión web de Laravel
        Auth::login($user, $request->filled('remember'));

        // Eliminar tokens anteriores y crear nuevo
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'user' => $user->load('role'),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        // Si es empresa, cargar datos de la empresa
        if ($user->isEmpresa() && $user->empresa) {
            $data['empresa'] = $user->empresa->load(['categoria', 'ciudad', 'plan']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'data' => $data
        ], 200);
    }

    /**
     * Logout Web
     */
    public function logout(Request $request)
    {
        // Eliminar tokens API
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Cerrar sesión web
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    }
}

