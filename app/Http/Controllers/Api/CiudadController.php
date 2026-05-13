<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::where('activo', true)
            ->withCount('empresas')
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $ciudades
        ], 200);
    }

    public function show($id)
    {
        $ciudad = Ciudad::with(['empresas' => function($query) {
            $query->activas()->ordenadoPorPlan()->take(20);
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $ciudad
        ], 200);
    }

    public function getMunicipios($ciudadId)
    {
        $ciudad = Ciudad::findOrFail($ciudadId);
        $municipios = $ciudad->municipios()->orderBy('nombre')->get();

        return response()->json([
            'success' => true,
            'data' => $municipios
        ], 200);
    }
}

