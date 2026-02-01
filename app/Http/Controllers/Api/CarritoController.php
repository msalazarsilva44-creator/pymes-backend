<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarritoController extends Controller
{
    /**
     * Listar items del carrito del usuario agrupados por empresa
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $items = Carrito::with(['servicio', 'empresa', 'empresa.metodosPago' => function($q) {
            $q->where('activo', true);
        }])
            ->where('user_id', $user->id)
            ->get();

        // Agrupar por empresa
        $porEmpresa = $items->groupBy('empresa_id')->map(function($items, $empresaId) {
            $empresa = $items->first()->empresa;
            $subtotal = $items->sum('precio');
            
            return [
                'empresa_id' => $empresaId,
                'empresa' => [
                    'id' => $empresa->id,
                    'nombre_comercial' => $empresa->nombre_comercial,
                    'logo' => $empresa->logo,
                ],
                'metodos_pago' => $empresa->metodosPago->map(function($mp) {
                    return [
                        'tipo' => $mp->tipo,
                        'tipo_nombre' => $mp->tipo_nombre,
                        'datos' => $mp->datos_formateados,
                    ];
                }),
                'items' => $items->map(function($item) {
                    return [
                        'id' => $item->id,
                        'servicio_id' => $item->servicio_id,
                        'nombre' => $item->servicio->nombre,
                        'descripcion' => $item->servicio->descripcion,
                        'precio' => $item->precio,
                    ];
                }),
                'subtotal' => $subtotal,
            ];
        })->values();

        $total = $items->sum('precio');
        $totalItems = $items->count();

        return response()->json([
            'success' => true,
            'data' => [
                'por_empresa' => $porEmpresa,
                'total' => $total,
                'total_items' => $totalItems,
            ]
        ]);
    }

    /**
     * Obtener solo el conteo de items en el carrito
     */
    public function count(Request $request)
    {
        $user = $request->user();
        
        $count = Carrito::where('user_id', $user->id)->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Agregar servicio al carrito
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $servicio = Servicio::with('empresa')->findOrFail($request->servicio_id);

        // Verificar que el servicio esté activo
        if (!$servicio->activo) {
            return response()->json([
                'success' => false,
                'message' => 'Este servicio no está disponible'
            ], 400);
        }

        // Verificar que la empresa esté activa y aprobada
        if (!$servicio->empresa->activo || !$servicio->empresa->aprobado) {
            return response()->json([
                'success' => false,
                'message' => 'Esta empresa no está disponible'
            ], 400);
        }

        // Verificar si ya está en el carrito
        $existente = Carrito::where('user_id', $user->id)
            ->where('servicio_id', $servicio->id)
            ->first();

        if ($existente) {
            return response()->json([
                'success' => false,
                'message' => 'Este servicio ya está en tu carrito'
            ], 400);
        }

        // Obtener precio (usar precio_desde o extraer de precio string)
        $precio = $servicio->precio_desde;
        if (!$precio && $servicio->precio) {
            // Intentar extraer número del string de precio
            preg_match('/[\d,.]+/', $servicio->precio, $matches);
            if (!empty($matches)) {
                $precio = floatval(str_replace(',', '.', $matches[0]));
            }
        }
        $precio = $precio ?: 0;

        // Crear item en carrito
        $carrito = Carrito::create([
            'user_id' => $user->id,
            'servicio_id' => $servicio->id,
            'empresa_id' => $servicio->empresa_id,
            'precio' => $precio,
        ]);

        $count = Carrito::where('user_id', $user->id)->count();

        return response()->json([
            'success' => true,
            'message' => 'Servicio agregado al carrito',
            'data' => $carrito,
            'cart_count' => $count
        ], 201);
    }

    /**
     * Eliminar item del carrito
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $item = Carrito::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item no encontrado en el carrito'
            ], 404);
        }

        $item->delete();

        $count = Carrito::where('user_id', $user->id)->count();

        return response()->json([
            'success' => true,
            'message' => 'Item eliminado del carrito',
            'cart_count' => $count
        ]);
    }

    /**
     * Vaciar todo el carrito
     */
    public function clear(Request $request)
    {
        $user = $request->user();

        Carrito::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Carrito vaciado',
            'cart_count' => 0
        ]);
    }

    /**
     * Vaciar carrito de una empresa específica
     */
    public function clearEmpresa(Request $request, $empresaId)
    {
        $user = $request->user();

        Carrito::where('user_id', $user->id)
            ->where('empresa_id', $empresaId)
            ->delete();

        $count = Carrito::where('user_id', $user->id)->count();

        return response()->json([
            'success' => true,
            'message' => 'Items de la empresa eliminados',
            'cart_count' => $count
        ]);
    }
}
