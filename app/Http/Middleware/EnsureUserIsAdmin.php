<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Verificar que el usuario autenticado sea administrador
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Intentar autenticación con Sanctum primero (para APIs con Bearer token)
        $user = auth('sanctum')->user();
        
        // Si no hay usuario con Sanctum, intentar con sesión web
        if (!$user) {
            $user = auth()->user();
        }

        // Verificar que el usuario esté autenticado
        if (!$user) {
            // Si es una petición AJAX/API, devolver JSON
            if ($request->expectsJson() || $request->is('admin/api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autenticado. Por favor inicia sesión.'
                ], 401);
            }
            
            // Si es petición web, redirigir al login
            return redirect('/login')->with('error', 'Debes iniciar sesión para acceder al panel de administración.');
        }

        // Cargar relación de rol si no está cargada
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        // Verificar que el usuario sea administrador
        if (!$user->isAdmin()) {
            // Si es una petición AJAX/API, devolver JSON
            if ($request->expectsJson() || $request->is('admin/api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acceso denegado. Se requieren permisos de administrador.'
                ], 403);
            }
            
            // Si es petición web, redirigir según el rol
            $role = $user->role->name ?? 'cliente';
            
            if ($role === 'empresa') {
                return redirect('/dashboard/empresa')->with('error', 'No tienes permisos de administrador.');
            } else {
                return redirect('/dashboard/cliente')->with('error', 'No tienes permisos de administrador.');
            }
        }

        return $next($request);
    }
}

