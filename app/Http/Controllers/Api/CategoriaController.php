<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('activa', true)
            ->withCount('empresas')
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categorias
        ], 200);
    }

    public function show($id)
    {
        $categoria = Categoria::with(['empresas' => function($query) {
            $query->activas()->ordenadoPorPlan()->take(20);
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $categoria
        ], 200);
    }
}

