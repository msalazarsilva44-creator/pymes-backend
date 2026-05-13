<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orden;
use App\Models\OrdenItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Reporte de ventas con filtros (fecha_desde, fecha_hasta, tipo)
     * Devuelve: items vendidos + KPIs + datos para gráfica agrupada por día
     */
    public function ventas(Request $request)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json(['success' => false, 'message' => 'No tienes empresa'], 403);
        }

        $request->validate([
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
            'tipo' => 'nullable|in:todos,servicio,producto',
        ]);

        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;
        $tipo = $request->tipo ?? 'todos';

        // Query base: orden_items con su orden, filtrados por empresa
        $query = OrdenItem::select(
                'orden_items.*',
                'ordenes.numero_orden',
                'ordenes.estado',
                'ordenes.created_at as orden_fecha',
                'ordenes.user_id'
            )
            ->join('ordenes', 'ordenes.id', '=', 'orden_items.orden_id')
            ->where('ordenes.empresa_id', $empresa->id);

        if ($fechaDesde) {
            $query->whereDate('ordenes.created_at', '>=', $fechaDesde);
        }
        if ($fechaHasta) {
            $query->whereDate('ordenes.created_at', '<=', $fechaHasta);
        }
        if ($tipo !== 'todos') {
            $query->where('orden_items.tipo', $tipo);
        }

        $items = $query->orderBy('ordenes.created_at', 'desc')->get();

        // Anonimizar clientes
        $userIds = $items->pluck('user_id')->unique()->values();
        $userMap = [];
        foreach ($userIds as $idx => $uid) {
            $userMap[$uid] = 'Cliente #' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT);
        }

        $rows = $items->map(function ($item) use ($userMap) {
            return [
                'id' => $item->id,
                'orden_id' => $item->orden_id,
                'numero_orden' => $item->numero_orden,
                'fecha' => $item->orden_fecha,
                'cliente' => $userMap[$item->user_id] ?? 'Desconocido',
                'tipo' => $item->tipo,
                'nombre' => $item->nombre_servicio,
                'cantidad' => (int) $item->cantidad,
                'precio_unitario' => (float) $item->precio,
                'total' => round((float) $item->precio * (int) $item->cantidad, 2),
                'estado' => $item->estado,
            ];
        });

        // KPIs
        $totalVentas = $rows->count();
        $montoTotal = $rows->sum('total');
        $ticketPromedio = $totalVentas > 0 ? round($montoTotal / $totalVentas, 2) : 0;

        // Gráfica agrupada por día: servicios vs productos
        $porDia = $rows->groupBy(function ($r) {
            return \Carbon\Carbon::parse($r['fecha'])->format('Y-m-d');
        })->map(function ($group, $date) {
            return [
                'fecha' => \Carbon\Carbon::parse($date)->format('d M'),
                'fecha_full' => $date,
                'servicios' => $group->where('tipo', 'servicio')->sum('total'),
                'productos' => $group->where('tipo', 'producto')->sum('total'),
            ];
        })->sortBy('fecha_full')->values();

        return response()->json([
            'success' => true,
            'data' => $rows->values(),
            'kpis' => [
                'total_ventas' => $totalVentas,
                'monto_total' => $montoTotal,
                'ticket_promedio' => $ticketPromedio,
            ],
            'grafica_diaria' => $porDia,
        ]);
    }

    /**
     * Ingresos por día — datos agrupados para la empresa
     * Acepta rango de fechas opcional
     */
    public function ingresosPorDia(Request $request)
    {
        $user = $request->user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json(['success' => false, 'message' => 'No tienes empresa'], 403);
        }

        $request->validate([
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date',
        ]);

        $fechaDesde = $request->fecha_desde ?? now()->subDays(29)->toDateString();
        $fechaHasta = $request->fecha_hasta ?? now()->toDateString();

        // Ingresos diarios (solo órdenes confirmadas/completadas)
        $ingresosDiarios = Orden::where('empresa_id', $empresa->id)
            ->whereIn('estado', ['confirmado', 'completado', 'pagado'])
            ->whereDate('created_at', '>=', $fechaDesde)
            ->whereDate('created_at', '<=', $fechaHasta)
            ->select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('COUNT(*) as ordenes'),
                DB::raw('SUM(total) as ingresos')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha')
            ->get();

        // KPIs
        $totalIngresos = $ingresosDiarios->sum('ingresos');
        $totalOrdenes = $ingresosDiarios->sum('ordenes');
        $diasConVentas = $ingresosDiarios->count();
        $promedioDiario = $diasConVentas > 0 ? round($totalIngresos / $diasConVentas, 2) : 0;
        $mejorDia = $ingresosDiarios->sortByDesc('ingresos')->first();

        // Formato para la gráfica
        $datosGrafica = $ingresosDiarios->map(function ($d) {
            return [
                'fecha' => \Carbon\Carbon::parse($d->fecha)->format('d M'),
                'fecha_full' => $d->fecha,
                'ingresos' => round((float) $d->ingresos, 2),
                'ordenes' => (int) $d->ordenes,
            ];
        })->values();

        // Ingresos por método de pago
        $porMetodo = Orden::where('empresa_id', $empresa->id)
            ->whereIn('estado', ['confirmado', 'completado', 'pagado'])
            ->whereDate('created_at', '>=', $fechaDesde)
            ->whereDate('created_at', '<=', $fechaHasta)
            ->select('metodo_pago', DB::raw('COUNT(*) as total_ordenes'), DB::raw('SUM(total) as monto'))
            ->groupBy('metodo_pago')
            ->get()
            ->map(function ($m) {
                return [
                    'metodo' => $m->metodo_pago ?? 'Sin definir',
                    'ordenes' => (int) $m->total_ordenes,
                    'monto' => round((float) $m->monto, 2),
                ];
            });

        return response()->json([
            'success' => true,
            'kpis' => [
                'total_ingresos' => round((float) $totalIngresos, 2),
                'total_ordenes' => $totalOrdenes,
                'promedio_diario' => $promedioDiario,
                'mejor_dia' => $mejorDia ? [
                    'fecha' => $mejorDia->fecha,
                    'ingresos' => round((float) $mejorDia->ingresos, 2),
                ] : null,
            ],
            'grafica' => $datosGrafica,
            'por_metodo' => $porMetodo,
        ]);
    }
}
