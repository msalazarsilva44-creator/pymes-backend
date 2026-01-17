<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Empresa;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Obtener notificaciones de la empresa
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Obtener empresa del usuario
        $empresa = Empresa::where('user_id', $user->id)->first();
        
        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró empresa asociada al usuario'
            ], 404);
        }

        // Obtener notificaciones (últimas 50, ordenadas por fecha)
        $notificaciones = Notification::where('empresa_id', $empresa->id)
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        // Contar no leídas
        $noLeidas = Notification::where('empresa_id', $empresa->id)
            ->noLeidas()
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'notificaciones' => $notificaciones,
                'no_leidas' => $noLeidas
            ]
        ], 200);
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::where('user_id', $user->id)->first();
        
        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        $notificacion = Notification::where('empresa_id', $empresa->id)
            ->where('id', $id)
            ->firstOrFail();

        $notificacion->marcarComoLeida();

        return response()->json([
            'success' => true,
            'message' => 'Notificación marcada como leída'
        ], 200);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasLeidas(Request $request)
    {
        $user = $request->user();
        $empresa = Empresa::where('user_id', $user->id)->first();
        
        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        Notification::where('empresa_id', $empresa->id)
            ->noLeidas()
            ->update([
                'leida' => true,
                'leida_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones marcadas como leídas'
        ], 200);
    }

    /**
     * Eliminar notificación
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::where('user_id', $user->id)->first();
        
        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        $notificacion = Notification::where('empresa_id', $empresa->id)
            ->where('id', $id)
            ->firstOrFail();

        $notificacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificación eliminada'
        ], 200);
    }
}
