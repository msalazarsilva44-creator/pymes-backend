<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
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
}

