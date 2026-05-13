<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Servicio;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $planes = Plan::where('activo', true)
            ->orderBy('posicion_prioridad', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $planes
        ], 200);
    }

    public function show($id)
    {
        $plan = Plan::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $plan
        ], 200);
    }

    /**
     * Obtener todos los servicios de todas las empresas (workaround)
     */
    public function getAllServicios(Request $request)
    {
        try {
            $query = Servicio::with('empresa')
                ->where('activo', true);

            // Filtrar solo empresas que ofrecen servicios (si tienen el campo)
            $query->whereHas('empresa', function($q) {
                $q->where(function($subQ) {
                    $subQ->where('ofrece_servicios', true)
                          ->orWhereNull('ofrece_servicios'); // Para empresas existentes sin el campo
                });
            });

            $servicios = $query->get();

            return response()->json([
                'success' => true,
                'data' => $servicios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener servicios',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

