<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resena;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResenaController extends Controller
{
    /**
     * Listar reseñas de una empresa
     */
    public function index($empresaId)
    {
        $resenas = Resena::where('empresa_id', $empresaId)
            ->visibles()
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $resenas
        ], 200);
    }

    /**
     * Crear una reseña
     */
    public function store(Request $request, $empresaId)
    {
        $validator = Validator::make($request->all(), [
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:100',
        ], [
            'comentario.required' => 'Debes escribir un comentario',
            'comentario.max' => 'El comentario no puede exceder 100 caracteres',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $empresa = Empresa::findOrFail($empresaId);

        // Verificar que no haya reseñado antes
        $existente = Resena::where('empresa_id', $empresaId)
            ->where('user_id', $user->id)
            ->first();

        if ($existente) {
            return response()->json([
                'success' => false,
                'message' => 'Ya has dejado una reseña para esta empresa'
            ], 400);
        }

        $resena = Resena::create([
            'empresa_id' => $empresaId,
            'user_id' => $user->id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'visible' => true,
        ]);

        // Actualizar calificación promedio de la empresa
        $this->actualizarCalificacionEmpresa($empresa);

        return response()->json([
            'success' => true,
            'message' => 'Reseña publicada exitosamente',
            'data' => $resena->load('user:id,name,avatar')
        ], 201);
    }

    /**
     * Responder a una reseña (solo propietario de la empresa)
     */
    public function responder(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'respuesta' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $resena = Resena::findOrFail($id);
        $user = $request->user();

        // Verificar que sea el propietario de la empresa
        if ($resena->empresa->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para responder esta reseña'
            ], 403);
        }

        $resena->update([
            'respuesta_empresa' => $request->respuesta,
            'respondido_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Respuesta publicada exitosamente',
            'data' => $resena
        ], 200);
    }

    /**
     * Actualizar calificación promedio de la empresa
     */
    private function actualizarCalificacionEmpresa(Empresa $empresa)
    {
        $stats = Resena::where('empresa_id', $empresa->id)
            ->visibles()
            ->selectRaw('AVG(calificacion) as promedio, COUNT(*) as total')
            ->first();

        $empresa->update([
            'calificacion_promedio' => round($stats->promedio, 2),
            'total_resenas' => $stats->total,
        ]);
    }
}

