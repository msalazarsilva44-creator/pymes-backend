<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Producto;
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

        $items = Carrito::with(['servicio', 'producto', 'empresa', 'empresa.metodosPago' => function($q) {
            $q->where('activo', true);
        }])
            ->where('user_id', $user->id)
            ->get();

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
                    $nombre = $item->tipo === 'producto'
                        ? ($item->producto?->nombre ?? 'Producto')
                        : ($item->servicio?->nombre ?? 'Servicio');
                    $descripcion = $item->tipo === 'producto'
                        ? ($item->producto?->descripcion ?? '')
                        : ($item->servicio?->descripcion ?? '');

                    return [
                        'id' => $item->id,
                        'tipo' => $item->tipo,
                        'servicio_id' => $item->servicio_id,
                        'producto_id' => $item->producto_id,
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                        'precio' => $item->precio,
                        'cantidad' => $item->cantidad ?? 1,
                        'es_basico' => $item->tipo === 'producto' ? (bool) ($item->producto?->es_basico) : false,
                    ];
                }),
                'subtotal' => $subtotal,
            ];
        })->values();

        $total = $items->sum('precio');
        $totalItems = $items->sum(fn ($i) => $i->cantidad ?? 1);

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
     * Obtener solo el conteo de unidades en el carrito
     */
    public function count(Request $request)
    {
        $user = $request->user();

        $count = (int) Carrito::where('user_id', $user->id)->sum('cantidad');

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Agregar servicio o producto al carrito
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'servicio_id' => 'nullable|exists:servicios,id',
            'producto_id' => 'nullable|exists:productos,id',
            'cantidad' => 'nullable|integer|min:1|max:9999',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $hasServicio = $request->filled('servicio_id');
        $hasProducto = $request->filled('producto_id');

        if ($hasServicio === $hasProducto) {
            return response()->json([
                'success' => false,
                'message' => 'Debes enviar servicio_id o producto_id (uno solo)'
            ], 422);
        }

        $user = $request->user();

        if ($hasServicio) {
            return $this->agregarServicio($request, $user);
        }

        return $this->agregarProducto($request, $user);
    }

    /**
     * Verificar si el carrito ya tiene items de otra empresa distinta.
     * Si ?force=true, vacía el carrito actual antes de continuar.
     * Retorna null si está OK, o un Response 409 con el conflicto.
     */
    protected function checkEmpresaConflict(Request $request, $user, $empresaIdNuevo)
    {
        $primerOtro = Carrito::with('empresa')
            ->where('user_id', $user->id)
            ->where('empresa_id', '!=', $empresaIdNuevo)
            ->first();

        if (!$primerOtro) {
            return null;
        }

        if ($request->boolean('force')) {
            Carrito::where('user_id', $user->id)->delete();
            return null;
        }

        return response()->json([
            'success' => false,
            'conflict' => true,
            'message' => 'Tu carrito tiene items de otra empresa',
            'empresa_actual' => [
                'id' => $primerOtro->empresa->id,
                'nombre_comercial' => $primerOtro->empresa->nombre_comercial,
            ],
        ], 409);
    }

    protected function agregarServicio(Request $request, $user)
    {
        $servicio = Servicio::with('empresa')->findOrFail($request->servicio_id);

        if (!$servicio->activo) {
            return response()->json([
                'success' => false,
                'message' => 'Este servicio no está disponible'
            ], 400);
        }

        if (!$servicio->empresa->activo || !$servicio->empresa->aprobado) {
            return response()->json([
                'success' => false,
                'message' => 'Esta empresa no está disponible'
            ], 400);
        }

        if ($conflict = $this->checkEmpresaConflict($request, $user, $servicio->empresa_id)) {
            return $conflict;
        }

        $existente = Carrito::where('user_id', $user->id)
            ->where('tipo', 'servicio')
            ->where('servicio_id', $servicio->id)
            ->first();

        if ($existente) {
            return response()->json([
                'success' => false,
                'message' => 'Este servicio ya está en tu carrito'
            ], 400);
        }

        $precio = $servicio->precio_desde;
        if (!$precio && $servicio->precio) {
            preg_match('/[\d,.]+/', $servicio->precio, $matches);
            if (!empty($matches)) {
                $precio = floatval(str_replace(',', '.', $matches[0]));
            }
        }
        $precio = $precio ?: 0;

        $carrito = Carrito::create([
            'user_id' => $user->id,
            'tipo' => 'servicio',
            'servicio_id' => $servicio->id,
            'producto_id' => null,
            'empresa_id' => $servicio->empresa_id,
            'precio' => $precio,
            'cantidad' => 1,
        ]);

        $count = (int) Carrito::where('user_id', $user->id)->sum('cantidad');

        return response()->json([
            'success' => true,
            'message' => 'Servicio agregado al carrito',
            'data' => $carrito,
            'cart_count' => $count
        ], 201);
    }

    protected function agregarProducto(Request $request, $user)
    {
        $cantidad = (int) $request->input('cantidad', 1);
        $producto = Producto::with('empresa')->findOrFail($request->producto_id);

        if (!$producto->activo) {
            return response()->json([
                'success' => false,
                'message' => 'Este producto no está disponible'
            ], 400);
        }

        if (!$producto->empresa->activo || !$producto->empresa->aprobado) {
            return response()->json([
                'success' => false,
                'message' => 'Esta empresa no está disponible'
            ], 400);
        }

        if ($conflict = $this->checkEmpresaConflict($request, $user, $producto->empresa_id)) {
            return $conflict;
        }

        if ($producto->cantidad < $cantidad) {
            return response()->json([
                'success' => false,
                'message' => 'No hay stock suficiente (disponible: ' . $producto->cantidad . ')'
            ], 400);
        }

        $existente = Carrito::where('user_id', $user->id)
            ->where('tipo', 'producto')
            ->where('producto_id', $producto->id)
            ->first();

        $precioUnit = (float) $producto->precio;

        if ($existente) {
            $nuevaCantidad = $existente->cantidad + $cantidad;
            if ($producto->cantidad < $nuevaCantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay stock suficiente (disponible: ' . $producto->cantidad . ', ya tienes ' . $existente->cantidad . ' en el carrito)'
                ], 400);
            }
            $existente->update([
                'cantidad' => $nuevaCantidad,
                'precio' => round($precioUnit * $nuevaCantidad, 2),
            ]);
            $carrito = $existente->fresh();
        } else {
            $carrito = Carrito::create([
                'user_id' => $user->id,
                'tipo' => 'producto',
                'servicio_id' => null,
                'producto_id' => $producto->id,
                'empresa_id' => $producto->empresa_id,
                'precio' => round($precioUnit * $cantidad, 2),
                'cantidad' => $cantidad,
            ]);
        }

        $count = (int) Carrito::where('user_id', $user->id)->sum('cantidad');

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'data' => $carrito,
            'cart_count' => $count
        ], 201);
    }

    /**
     * Actualizar la cantidad de un item del carrito (solo productos).
     */
    public function actualizarCantidad(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1|max:9999',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $cantidad = (int) $request->cantidad;

        $item = Carrito::where('user_id', $user->id)->where('id', $id)->first();
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item no encontrado'
            ], 404);
        }

        if ($item->tipo === 'servicio') {
            return response()->json([
                'success' => false,
                'message' => 'La cantidad de servicios no es editable'
            ], 400);
        }

        $producto = Producto::find($item->producto_id);
        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no disponible'
            ], 400);
        }

        if ($producto->cantidad < $cantidad) {
            return response()->json([
                'success' => false,
                'message' => 'No hay stock suficiente (disponible: ' . $producto->cantidad . ')'
            ], 400);
        }

        $precioUnit = (float) $producto->precio;
        $item->update([
            'cantidad' => $cantidad,
            'precio' => round($precioUnit * $cantidad, 2),
        ]);

        $count = (int) Carrito::where('user_id', $user->id)->sum('cantidad');

        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada',
            'data' => $item->fresh(),
            'cart_count' => $count,
        ]);
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

        $count = (int) Carrito::where('user_id', $user->id)->sum('cantidad');

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

        $count = (int) Carrito::where('user_id', $user->id)->sum('cantidad');

        return response()->json([
            'success' => true,
            'message' => 'Items de la empresa eliminados',
            'cart_count' => $count
        ]);
    }
}
