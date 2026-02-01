<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Orden;
use App\Models\OrdenItem;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrdenController extends Controller
{
    /**
     * Crear orden desde el carrito (para una empresa específica)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'empresa_id' => 'required|exists:empresas,id',
            'metodo_pago' => 'required|in:paypal,binance,transferencia,pago_movil',
            'referencia_pago' => 'nullable|string|max:100',
            'comprobante_pago' => 'nullable|image|max:5120', // 5MB max
            'notas_cliente' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Obtener items del carrito para esta empresa
        $itemsCarrito = Carrito::with('servicio')
            ->where('user_id', $user->id)
            ->where('empresa_id', $request->empresa_id)
            ->get();

        if ($itemsCarrito->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay items en el carrito para esta empresa'
            ], 400);
        }

        // Calcular total
        $subtotal = $itemsCarrito->sum('precio');
        $total = $subtotal; // Sin impuestos por ahora

        DB::beginTransaction();
        try {
            // Subir comprobante si existe
            $comprobantePath = null;
            if ($request->hasFile('comprobante_pago')) {
                $comprobantePath = $request->file('comprobante_pago')
                    ->store('comprobantes_pago', 'public');
            }

            // Crear orden
            $orden = Orden::create([
                'numero_orden' => Orden::generarNumeroOrden(),
                'user_id' => $user->id,
                'empresa_id' => $request->empresa_id,
                'subtotal' => $subtotal,
                'total' => $total,
                'estado' => $comprobantePath ? 'pagado' : 'pendiente',
                'metodo_pago' => $request->metodo_pago,
                'referencia_pago' => $request->referencia_pago,
                'comprobante_pago' => $comprobantePath,
                'notas_cliente' => $request->notas_cliente,
                'pagado_at' => $comprobantePath ? now() : null,
            ]);

            // Crear items de la orden
            foreach ($itemsCarrito as $item) {
                OrdenItem::create([
                    'orden_id' => $orden->id,
                    'servicio_id' => $item->servicio_id,
                    'nombre_servicio' => $item->servicio->nombre,
                    'descripcion_servicio' => $item->servicio->descripcion,
                    'precio' => $item->precio,
                ]);
            }

            // Eliminar items del carrito
            Carrito::where('user_id', $user->id)
                ->where('empresa_id', $request->empresa_id)
                ->delete();

            DB::commit();

            // Cargar relaciones para la respuesta
            $orden->load(['items', 'empresa']);

            return response()->json([
                'success' => true,
                'message' => 'Orden creada exitosamente',
                'data' => $orden
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Subir comprobante de pago para una orden pendiente
     */
    public function subirComprobante(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comprobante_pago' => 'required|image|max:5120',
            'referencia_pago' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $orden = Orden::where('user_id', $user->id)->findOrFail($id);

        if ($orden->estado !== 'pendiente') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se puede subir comprobante para órdenes pendientes'
            ], 400);
        }

        // Eliminar comprobante anterior si existe
        if ($orden->comprobante_pago) {
            Storage::disk('public')->delete($orden->comprobante_pago);
        }

        $comprobantePath = $request->file('comprobante_pago')
            ->store('comprobantes_pago', 'public');

        $orden->update([
            'comprobante_pago' => $comprobantePath,
            'referencia_pago' => $request->referencia_pago ?? $orden->referencia_pago,
            'estado' => 'pagado',
            'pagado_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comprobante subido exitosamente',
            'data' => $orden
        ]);
    }

    /**
     * Listar órdenes del cliente autenticado
     */
    public function misOrdenes(Request $request)
    {
        $user = $request->user();

        $ordenes = Orden::with(['items', 'empresa'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $ordenes
        ]);
    }

    /**
     * Listar órdenes de la empresa del usuario autenticado
     */
    public function ordenesEmpresa(Request $request)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una empresa registrada'
            ], 403);
        }

        $query = Orden::with(['items', 'user'])
            ->where('empresa_id', $empresa->id);

        // Filtro por estado
        if ($request->has('estado') && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }

        $ordenes = $query->orderBy('created_at', 'desc')->get();

        // Estadísticas
        $stats = [
            'total' => Orden::where('empresa_id', $empresa->id)->count(),
            'pendientes' => Orden::where('empresa_id', $empresa->id)->where('estado', 'pendiente')->count(),
            'pagadas' => Orden::where('empresa_id', $empresa->id)->where('estado', 'pagado')->count(),
            'confirmadas' => Orden::where('empresa_id', $empresa->id)->where('estado', 'confirmado')->count(),
            'completadas' => Orden::where('empresa_id', $empresa->id)->where('estado', 'completado')->count(),
            'monto_total' => Orden::where('empresa_id', $empresa->id)->whereIn('estado', ['confirmado', 'completado'])->sum('total'),
        ];

        return response()->json([
            'success' => true,
            'data' => $ordenes,
            'stats' => $stats
        ]);
    }

    /**
     * Ver detalle de una orden
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        
        $orden = Orden::with(['items', 'empresa', 'user'])->findOrFail($id);

        // Verificar que el usuario sea el cliente o la empresa
        $esCliente = $orden->user_id === $user->id;
        $esEmpresa = $user->empresa && $orden->empresa_id === $user->empresa->id;

        if (!$esCliente && !$esEmpresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para ver esta orden'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $orden
        ]);
    }

    /**
     * Empresa confirma el pago de una orden
     */
    public function confirmar(Request $request, $id)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una empresa registrada'
            ], 403);
        }

        $orden = Orden::where('empresa_id', $empresa->id)->findOrFail($id);

        if ($orden->estado !== 'pagado') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden confirmar órdenes con estado "pagado"'
            ], 400);
        }

        $orden->update([
            'estado' => 'confirmado',
            'confirmado_at' => now(),
            'notas_empresa' => $request->notas_empresa ?? $orden->notas_empresa,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pago confirmado exitosamente',
            'data' => $orden
        ]);
    }

    /**
     * Empresa marca orden como completada
     */
    public function completar(Request $request, $id)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes una empresa registrada'
            ], 403);
        }

        $orden = Orden::where('empresa_id', $empresa->id)->findOrFail($id);

        if (!in_array($orden->estado, ['confirmado', 'pagado'])) {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden completar órdenes confirmadas o pagadas'
            ], 400);
        }

        $orden->update([
            'estado' => 'completado',
            'completado_at' => now(),
            'notas_empresa' => $request->notas_empresa ?? $orden->notas_empresa,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orden marcada como completada',
            'data' => $orden
        ]);
    }

    /**
     * Cancelar una orden
     */
    public function cancelar(Request $request, $id)
    {
        $user = $request->user();
        
        $orden = Orden::findOrFail($id);

        // Verificar permisos
        $esCliente = $orden->user_id === $user->id;
        $esEmpresa = $user->empresa && $orden->empresa_id === $user->empresa->id;

        if (!$esCliente && !$esEmpresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para cancelar esta orden'
            ], 403);
        }

        // Solo se pueden cancelar órdenes pendientes o pagadas
        if (!in_array($orden->estado, ['pendiente', 'pagado'])) {
            return response()->json([
                'success' => false,
                'message' => 'Esta orden no puede ser cancelada'
            ], 400);
        }

        $orden->update([
            'estado' => 'cancelado',
            'cancelado_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orden cancelada',
            'data' => $orden
        ]);
    }

    /**
     * Reportes de ventas para Admin
     */
    public function reportesAdmin(Request $request)
    {
        // Solo admin puede acceder
        $user = $request->user();
        if (!$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Acceso denegado'
            ], 403);
        }

        $query = Orden::with(['empresa', 'user']);

        // Filtros
        if ($request->has('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }
        if ($request->has('estado') && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }
        if ($request->has('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->has('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $ordenes = $query->orderBy('created_at', 'desc')->get();

        // Estadísticas globales
        $stats = [
            'total_ordenes' => Orden::count(),
            'ordenes_completadas' => Orden::where('estado', 'completado')->count(),
            'ordenes_pendientes' => Orden::whereIn('estado', ['pendiente', 'pagado'])->count(),
            'volumen_total' => Orden::whereIn('estado', ['confirmado', 'completado'])->sum('total'),
            'empresas_con_ventas' => Orden::distinct('empresa_id')->count('empresa_id'),
        ];

        return response()->json([
            'success' => true,
            'data' => $ordenes,
            'stats' => $stats
        ]);
    }
}
