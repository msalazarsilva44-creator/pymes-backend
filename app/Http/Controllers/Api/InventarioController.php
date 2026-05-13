<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventarioMovimiento;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Registrar ingreso de mercancía.
     * POST /empresa/productos/ingreso
     */
    public function ingreso(Request $request)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una empresa registrada'
            ], 403);
        }

        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'comentario' => 'required|string|max:300',
        ]);

        // Verificar que el producto pertenece a la empresa
        $producto = Producto::where('id', $request->producto_id)
            ->where('empresa_id', $empresa->id)
            ->first();

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado o no pertenece a tu empresa'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $cantidadAnterior = (int) $producto->cantidad;
            $cantidadNueva = $cantidadAnterior + (int) $request->cantidad;

            // Registrar movimiento
            InventarioMovimiento::create([
                'proveedor_id' => $empresa->id,
                'producto_id' => $producto->id,
                'tipo_movimiento' => 'ingreso',
                'cantidad' => (int) $request->cantidad,
                'cantidad_anterior' => $cantidadAnterior,
                'cantidad_resultante' => $cantidadNueva,
                'comentario' => $request->comentario,
                'usuario_id' => $user->id,
                'fecha_movimiento' => now(),
            ]);

            // Actualizar stock del producto
            $producto->update(['cantidad' => $cantidadNueva]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ingreso registrado correctamente. Stock actualizado.',
                'cantidad_nueva' => $cantidadNueva,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
