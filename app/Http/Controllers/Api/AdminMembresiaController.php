<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminMembresiaController extends Controller
{
    /**
     * Listado completo (incluye inactivas) — Admin
     */
    public function index()
    {
        $planes = Plan::withCount('empresas')
            ->orderBy('orden')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $planes,
        ]);
    }

    /**
     * Crear nuevo plan/membresía
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:60',
            'descripcion'     => 'nullable|string|max:200',
            'precio_mensual'  => 'required|numeric|min:0',
            'precio_anual'    => 'required|numeric|min:0',
            'caracteristicas' => 'nullable|array',
            'caracteristicas.*' => 'string|max:100',
            'color_badge'     => 'in:blue,violet,emerald,amber,rose',
            'destacado'       => 'boolean',
            'activo'          => 'boolean',
            'orden'           => 'integer|min:0',
            'max_fotos'       => 'integer|min:0',
            'posicion_prioridad' => 'integer|min:0',
            'panel_metricas'     => 'boolean',
            'notificaciones_push' => 'boolean',
            'verificacion_perfil' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);

        // Verificar slug único
        if (Plan::where('slug', $validated['slug'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un plan con ese nombre',
            ], 422);
        }

        // Si se marca como destacado, quitar destacado de los demás
        if (!empty($validated['destacado'])) {
            Plan::where('destacado', true)->update(['destacado' => false]);
        }

        $plan = Plan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Membresía creada exitosamente',
            'data' => $plan,
        ], 201);
    }

    /**
     * Actualizar plan/membresía
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'nombre'          => 'required|string|max:60',
            'descripcion'     => 'nullable|string|max:200',
            'precio_mensual'  => 'required|numeric|min:0',
            'precio_anual'    => 'required|numeric|min:0',
            'caracteristicas' => 'nullable|array',
            'caracteristicas.*' => 'string|max:100',
            'color_badge'     => 'in:blue,violet,emerald,amber,rose',
            'destacado'       => 'boolean',
            'activo'          => 'boolean',
            'orden'           => 'integer|min:0',
            'max_fotos'       => 'integer|min:0',
            'posicion_prioridad' => 'integer|min:0',
            'panel_metricas'     => 'boolean',
            'notificaciones_push' => 'boolean',
            'verificacion_perfil' => 'boolean',
        ]);

        $newSlug = Str::slug($validated['nombre']);

        // Verificar slug único excluyendo el actual
        if (Plan::where('slug', $newSlug)->where('id', '!=', $id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un plan con ese nombre',
            ], 422);
        }

        $validated['slug'] = $newSlug;

        // Si se marca como destacado, quitar destacado de los demás
        if (!empty($validated['destacado'])) {
            Plan::where('destacado', true)->where('id', '!=', $id)->update(['destacado' => false]);
        }

        $plan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Membresía actualizada exitosamente',
            'data' => $plan->fresh(),
        ]);
    }

    /**
     * Eliminar plan/membresía
     */
    public function destroy($id)
    {
        $plan = Plan::withCount('empresas')->findOrFail($id);

        if ($plan->empresas_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "No puedes eliminar esta membresía porque tiene {$plan->empresas_count} proveedores activos. Desactívala en su lugar.",
            ], 409);
        }

        $plan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Membresía eliminada exitosamente',
        ]);
    }

    /**
     * Toggle activo/inactivo
     */
    public function toggle($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->activo = !$plan->activo;
        $plan->save();

        return response()->json([
            'success' => true,
            'message' => $plan->activo ? 'Membresía activada' : 'Membresía desactivada',
            'data' => $plan,
        ]);
    }

    /**
     * Planes activos — ruta pública para PagoEmpresa.tsx
     */
    public function activas()
    {
        $planes = Plan::where('activo', true)
            ->orderBy('orden')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $planes,
        ]);
    }
}
