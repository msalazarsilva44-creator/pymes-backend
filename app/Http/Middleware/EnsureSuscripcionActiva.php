<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuscripcionActiva
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && method_exists($user, 'empresa') && $user->empresa) {
            $empresa = $user->empresa->loadMissing('plan', 'suscripcionVigente');
            $suscripcion = $empresa->suscripcion ?? null;

            if ($empresa->plan_id !== null) {
                $estado = $suscripcion['estado_acceso'] ?? null;

                if (in_array($estado, ['vencida', 'pendiente_pago'])) {
                    return response()->json([
                        'message' => 'Tu suscripción está vencida o pendiente de pago.',
                        'estado_acceso' => $estado,
                        'codigo' => 'SUSCRIPCION_INACTIVA',
                    ], 402);
                }
            }
        }

        return $next($request);
    }
}
