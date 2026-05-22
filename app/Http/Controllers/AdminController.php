<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\Resena;
use App\Models\Metrica;
use App\Models\Suscripcion;
use App\Models\Categoria;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Obtener estadísticas generales del dashboard
     */
    public function getStats(Request $request)
    {
        try {
            // Estadísticas principales
            $totalEmpresas = Empresa::count();
            $empresasActivas = Empresa::where('activo', true)->count();
            $empresasPendientes = Empresa::where('aprobado', false)->count();
            
            // Total de usuarios por rol
            $totalClientes = User::whereHas('role', function($q) {
                $q->where('name', 'cliente');
            })->count();
            
            // Suscripciones pendientes
            $suscripcionesPendientes = Suscripcion::where('estado', 'pendiente_aprobacion')->count();
            
            $totalUsuarios = User::count();
            
            // Estadísticas adicionales
            $totalResenas = Resena::count();
            $nuevasHoy = Empresa::whereDate('created_at', today())->count();
            $nuevasEstaSemana = Empresa::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count();
            
            // Distribución por plan
            $porPlan = [
                'gratis' => Empresa::whereHas('plan', function($q) {
                    $q->where('slug', 'gratis');
                })->count(),
                'basico' => Empresa::whereHas('plan', function($q) {
                    $q->where('slug', 'basico');
                })->count(),
                'premium' => Empresa::whereHas('plan', function($q) {
                    $q->where('slug', 'premium');
                })->count(),
            ];
            
            // Métricas totales de actividad
            $totalVistas = Metrica::where('tipo', 'vista')->count();
            $totalClics = Metrica::whereIn('tipo', [
                'clic_telefono',
                'clic_whatsapp',
                'clic_sitio_web',
                'clic_direccion'
            ])->count();
            
            // Empresas por categoría (top 5)
            $topCategorias = Empresa::with('categoria')
                ->selectRaw('categoria_id, COUNT(*) as total')
                ->groupBy('categoria_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'nombre' => $item->categoria->nombre ?? 'Sin categoría',
                        'total' => $item->total
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    // Stats principales
                    'total_empresas' => $totalEmpresas,
                    'empresas_activas' => $empresasActivas,
                    'empresas_pendientes' => $empresasPendientes,
                    'suscripciones_pendientes' => $suscripcionesPendientes,
                    'total_clientes' => $totalClientes,
                    'total_usuarios' => $totalUsuarios,
                    
                    // Stats adicionales
                    'total_resenas' => $totalResenas,
                    'nuevas_hoy' => $nuevasHoy,
                    'nuevas_esta_semana' => $nuevasEstaSemana,
                    
                    // Distribuciones
                    'por_plan' => $porPlan,
                    'top_categorias' => $topCategorias,
                    
                    // Métricas de actividad
                    'total_vistas' => $totalVistas,
                    'total_clics' => $totalClics,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Listar empresas pendientes de aprobación
     */
    public function empresasPendientes(Request $request)
    {
        try {
            $empresas = Empresa::with(['categoria', 'ciudad', 'municipio', 'plan', 'user'])
                ->where('aprobado', false)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $empresas
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar empresas pendientes',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Obtener detalle de una empresa específica
     */
    public function getEmpresa(Request $request, $id)
    {
        try {
            $empresa = Empresa::with([
                'categoria',
                'ciudad',
                'municipio',
                'plan',
                'user',
                'fotos',
                'servicios',
                'horarios',
                'resenas'
            ])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $empresa
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar empresa',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 404);
        }
    }

    /**
     * Listar todas las empresas aprobadas
     */
    public function getEmpresas(Request $request)
    {
        try {
            $empresas = Empresa::with(['categoria', 'ciudad', 'municipio', 'plan'])
                ->where('aprobado', true)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $empresas
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar empresas',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Aprobar o rechazar una empresa
     */
    public function aprobarEmpresa(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'accion' => 'required|in:aprobar,rechazar',
            'motivo' => 'required_if:accion,rechazar|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $empresa = Empresa::with(['user'])->findOrFail($id);

            if ($request->accion === 'aprobar') {
                $empresa->update([
                    'aprobado' => true,
                    'aprobado_at' => now(),
                    'aprobado_por' => auth()->id(),
                    'activo' => true,
                    'motivo_rechazo' => null,
                ]);

                // Crear notificación para la empresa
                Notification::create([
                    'empresa_id' => $empresa->id,
                    'tipo' => 'aprobacion',
                    'titulo' => '¡Felicitaciones! Tu empresa ha sido aprobada',
                    'mensaje' => 'Tu solicitud para unirte a ServiLocal ha sido aprobada exitosamente. Tu empresa ahora es visible en el marketplace y los clientes pueden encontrarte.',
                    'data' => [
                        'accion' => 'empresa_aprobada',
                        'fecha_aprobacion' => now()->toDateTimeString(),
                        'aprobado_por' => auth()->user()->name ?? 'Administrador'
                    ],
                    'leida' => false,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Empresa aprobada exitosamente. Ahora es visible en el marketplace.',
                    'data' => $empresa
                ], 200);

            } else { // rechazar
                $empresa->update([
                    'aprobado' => false,
                    'aprobado_at' => null,
                    'aprobado_por' => auth()->id(),
                    'activo' => false,
                    'motivo_rechazo' => $request->motivo,
                ]);

                // Crear notificación para la empresa rechazada
                Notification::create([
                    'empresa_id' => $empresa->id,
                    'tipo' => 'rechazo',
                    'titulo' => 'Solicitud rechazada',
                    'mensaje' => 'Lamentamos informarte que tu solicitud para unirte a ServiLocal ha sido rechazada. Motivo: ' . $request->motivo,
                    'data' => [
                        'accion' => 'empresa_rechazada',
                        'motivo' => $request->motivo,
                        'fecha_rechazo' => now()->toDateTimeString(),
                        'rechazado_por' => auth()->user()->name ?? 'Administrador'
                    ],
                    'leida' => false,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Empresa rechazada. Se ha notificado al usuario.',
                    'data' => $empresa
                ], 200);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Obtener todos los usuarios (para gestión)
     */
    public function getUsuarios(Request $request)
    {
        try {
            $usuarios = User::with('role')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $usuarios
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar usuarios',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Listar empresas con paginación y filtros (para módulo de gestión)
     */
    public function listarEmpresasGestion(Request $request)
    {
        try {
            $query = Empresa::with(['categoria', 'ciudad', 'municipio', 'plan', 'user', 'suscripcionActiva']);

            // Filtro de búsqueda
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre_comercial', 'LIKE', "%{$search}%")
                      ->orWhere('rfc', 'LIKE', "%{$search}%")
                      ->orWhere('email_contacto', 'LIKE', "%{$search}%");
                });
            }

            // Filtro por categoría
            if ($request->filled('categoria_id')) {
                $query->where('categoria_id', $request->categoria_id);
            }

            // Filtro por ciudad
            if ($request->filled('ciudad_id')) {
                $query->where('ciudad_id', $request->ciudad_id);
            }

            // Filtro por plan
            if ($request->filled('plan_id')) {
                $query->where('plan_id', $request->plan_id);
            }

            // Filtro por estado
            if ($request->filled('estado')) {
                switch ($request->estado) {
                    case 'activa':
                        $query->where('activo', true)->where('penalizada', false);
                        break;
                    case 'inactiva':
                        $query->where('activo', false)->where('penalizada', false);
                        break;
                    case 'penalizada':
                        $query->where('penalizada', true);
                        break;
                    case 'pendiente':
                        $query->where('aprobado', false);
                        break;
                }
            }

            // Ordenamiento
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginación
            $perPage = $request->input('per_page', 20);
            $empresas = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $empresas
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar empresas',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Toggle estado activo de empresa (Desactivar/Activar)
     */
    public function toggleEmpresaEstado(Request $request, $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);
            
            $nuevoEstado = !$empresa->activo;
            $empresa->update(['activo' => $nuevoEstado]);

            $mensaje = $nuevoEstado ? 'Empresa activada exitosamente' : 'Empresa desactivada del marketplace';

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => [
                    'activo' => $nuevoEstado
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar estado de la empresa',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Penalizar empresa
     */
    public function penalizarEmpresa(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'motivo' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $empresa = Empresa::findOrFail($id);
            
            $empresa->update([
                'penalizada' => true,
                'motivo_penalizacion' => $request->motivo,
                'penalizada_at' => now(),
                'penalizada_por' => auth()->id(),
                'activo' => false // Desactivar del marketplace automáticamente
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Empresa penalizada exitosamente',
                'data' => $empresa->fresh(['user'])
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al penalizar la empresa',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Quitar penalización de empresa
     */
    public function quitarPenalizacion(Request $request, $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);
            
            $empresa->update([
                'penalizada' => false,
                'motivo_penalizacion' => null,
                'penalizada_at' => null,
                'penalizada_por' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Penalización removida exitosamente',
                'data' => $empresa
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al quitar penalización',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Eliminar empresa (soft delete)
     */
    public function eliminarEmpresa(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'motivo' => 'required|string|max:1000',
            'confirmacion' => 'required|string|in:ELIMINAR',
        ], [
            'confirmacion.in' => 'Debes escribir exactamente "ELIMINAR" para confirmar'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $empresa = Empresa::findOrFail($id);
            
            // Guardar motivo antes de eliminar
            $empresa->update([
                'motivo_suspension' => $request->motivo,
                'activo' => false,
            ]);

            // Soft delete
            $empresa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empresa eliminada exitosamente'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la empresa',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // ==================== GESTIÓN DE SUSCRIPCIONES ====================

    /**
     * Obtener suscripciones pendientes de aprobación
     */
    public function suscripcionesPendientes(Request $request)
    {
        try {
            // Primero verificar cuántas hay sin relaciones
            $count = Suscripcion::where('estado', 'pendiente_aprobacion')->count();
            
            // Cargar suscripciones SIN eager loading primero para ver si ese es el problema
            $suscripciones = Suscripcion::where('estado', 'pendiente_aprobacion')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Cargar relaciones manualmente
            $suscripciones->load('empresa', 'plan');

            return response()->json([
                'success' => true,
                'suscripciones' => $suscripciones,
                'count' => $count,
                'loaded' => $suscripciones->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar suscripciones pendientes',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Aprobar una suscripción
     */
    public function aprobarSuscripcion(Request $request, $id)
    {
        try {
            $suscripcion = Suscripcion::with('empresa', 'plan')->findOrFail($id);

            // Verificar que esté pendiente
            if (!$suscripcion->isPendienteAprobacion()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta suscripción no está pendiente de aprobación'
                ], 400);
            }

            $now = now();

            $ultimaActiva = Suscripcion::where('empresa_id', $suscripcion->empresa_id)
                ->where('estado', 'activa')
                ->orderByDesc('fecha_fin')
                ->first();

            $base = $now->copy();
            $fechaInicio = $now->copy();

            if ($ultimaActiva && $ultimaActiva->fecha_fin) {
                $fechaFinAnterior = Carbon::parse($ultimaActiva->fecha_fin);
                if ($fechaFinAnterior->isFuture()) {
                    $base = $fechaFinAnterior->copy();
                    $fechaInicio = $fechaFinAnterior->copy();
                }
            }

            $fechaFin = $suscripcion->tipo_periodo === 'anual'
                ? $base->copy()->addYear()
                : $base->copy()->addMonth();

            // Actualizar estado de la suscripción
            $suscripcion->update([
                'estado' => 'activa',
                'aprobada_por' => auth()->id(),
                'aprobada_at' => $now,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
            ]);

            // Actualizar el plan de la empresa
            $empresa = $suscripcion->empresa;
            $empresa->update([
                'plan_id' => $suscripcion->plan_id
            ]);

            // Si el plan tiene boost, activarlo
            if ($suscripcion->plan->dias_boost > 0) {
                $empresa->activarBoost($suscripcion->plan->dias_boost);
            }

            return response()->json([
                'success' => true,
                'message' => 'Suscripción aprobada exitosamente',
                'suscripcion' => $suscripcion->load('empresa', 'plan', 'aprobadaPor')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar la suscripción',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Rechazar una suscripción
     */
    public function rechazarSuscripcion(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'motivo' => 'required|string|min:10|max:1000'
            ], [
                'motivo.required' => 'El motivo del rechazo es obligatorio',
                'motivo.min' => 'El motivo debe tener al menos 10 caracteres',
                'motivo.max' => 'El motivo no puede exceder 1000 caracteres'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $suscripcion = Suscripcion::with('empresa', 'plan')->findOrFail($id);

            // Verificar que esté pendiente
            if (!$suscripcion->isPendienteAprobacion()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta suscripción no está pendiente de aprobación'
                ], 400);
            }

            // Actualizar estado de la suscripción
            $suscripcion->update([
                'estado' => 'rechazada',
                'motivo_rechazo' => $request->motivo,
                'aprobada_por' => auth()->id(),
                'aprobada_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Suscripción rechazada',
                'suscripcion' => $suscripcion->load('empresa', 'plan', 'aprobadaPor')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar la suscripción',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // ==================== GESTIÓN DE CATEGORÍAS ====================

    /**
     * Listar todas las categorías con conteo de empresas
     */
    public function getCategorias(Request $request)
    {
        try {
            $query = Categoria::withCount('empresas');

            // Búsqueda
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('descripcion', 'LIKE', "%{$search}%");
                });
            }

            // Filtro por estado
            if ($request->has('activa') && $request->activa !== '') {
                $query->where('activa', $request->activa);
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'nombre');
            $sortOrder = $request->get('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);

            $categorias = $query->paginate($request->get('per_page', 20));

            return response()->json([
                'success' => true,
                'categorias' => $categorias
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar categorías',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Obtener una categoría específica
     */
    public function getCategoria($id)
    {
        try {
            $categoria = Categoria::withCount('empresas')->findOrFail($id);

            return response()->json([
                'success' => true,
                'categoria' => $categoria
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Categoría no encontrada',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 404);
        }
    }

    /**
     * Crear nueva categoría
     */
    public function crearCategoria(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100|unique:categorias,nombre',
                'descripcion' => 'nullable|string|max:500',
                'icono' => 'nullable|string|max:50',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.unique' => 'Ya existe una categoría con este nombre',
                'nombre.max' => 'El nombre no puede exceder 100 caracteres',
                'descripcion.max' => 'La descripción no puede exceder 500 caracteres',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generar slug único
            $slug = Str::slug($request->nombre);
            $slugOriginal = $slug;
            $contador = 1;
            
            while (Categoria::where('slug', $slug)->exists()) {
                $slug = $slugOriginal . '-' . $contador;
                $contador++;
            }

            $categoria = Categoria::create([
                'nombre' => $request->nombre,
                'slug' => $slug,
                'descripcion' => $request->descripcion,
                'icono' => $request->icono ?? null,
                'activa' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Categoría creada exitosamente',
                'categoria' => $categoria
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la categoría',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Actualizar categoría existente
     */
    public function actualizarCategoria(Request $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $id,
                'descripcion' => 'nullable|string|max:500',
                'icono' => 'nullable|string|max:50',
                'activa' => 'boolean',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.unique' => 'Ya existe una categoría con este nombre',
                'nombre.max' => 'El nombre no puede exceder 100 caracteres',
                'descripcion.max' => 'La descripción no puede exceder 500 caracteres',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Regenerar slug si cambió el nombre
            if ($request->nombre !== $categoria->nombre) {
                $slug = Str::slug($request->nombre);
                $slugOriginal = $slug;
                $contador = 1;
                
                while (Categoria::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $slugOriginal . '-' . $contador;
                    $contador++;
                }
                
                $categoria->slug = $slug;
            }

            $categoria->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'activa' => $request->has('activa') ? $request->activa : $categoria->activa,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Categoría actualizada exitosamente',
                'categoria' => $categoria->load('empresas')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la categoría',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Eliminar categoría
     */
    public function eliminarCategoria($id)
    {
        try {
            $categoria = Categoria::withCount('empresas')->findOrFail($id);

            // Verificar si tiene empresas asociadas
            if ($categoria->empresas_count > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "No se puede eliminar esta categoría porque tiene {$categoria->empresas_count} empresa(s) asociada(s). Primero reasigna las empresas a otra categoría."
                ], 400);
            }

            $categoria->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la categoría',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Alternar estado activa/inactiva
     */
    public function toggleCategoriaEstado($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            
            $categoria->activa = !$categoria->activa;
            $categoria->save();

            return response()->json([
                'success' => true,
                'message' => $categoria->activa ? 'Categoría activada' : 'Categoría desactivada',
                'categoria' => $categoria
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Dashboard Ejecutivo - Reporte con KPIs principales
     */
    public function reporteEjecutivo(Request $request)
    {
        try {
            // Obtener rango de fechas (por defecto: último mes)
            $fechaInicio = $request->input('fecha_inicio', now()->subMonth()->startOfDay());
            $fechaFin = $request->input('fecha_fin', now()->endOfDay());
            
            // Para comparar con período anterior
            $diasPeriodo = now()->parse($fechaFin)->diffInDays(now()->parse($fechaInicio));
            $fechaInicioAnterior = now()->parse($fechaInicio)->subDays($diasPeriodo);
            $fechaFinAnterior = now()->parse($fechaInicio)->subDay();

            // ========== KPI 1: MRR (Monthly Recurring Revenue) ==========
            $suscripcionesActivas = Suscripcion::where('estado', 'activa')
                ->where('fecha_fin', '>=', now())
                ->with('plan')
                ->get();
            
            $mrr = 0;
            foreach ($suscripcionesActivas as $suscripcion) {
                if ($suscripcion->tipo_periodo === 'anual') {
                    // Convertir anual a mensual (dividir entre 12)
                    $mrr += $suscripcion->precio_pagado / 12;
                } else {
                    $mrr += $suscripcion->precio_pagado;
                }
            }
            
            // ========== KPI 2: Total Empresas Activas ==========
            $empresasActivas = Empresa::where('activo', true)
                ->where('aprobado', true)
                ->count();
            
            $empresasActivasAnterior = Empresa::where('activo', true)
                ->where('aprobado', true)
                ->where('created_at', '<', $fechaInicio)
                ->count();
            
            $crecimientoEmpresas = $empresasActivasAnterior > 0 
                ? (($empresasActivas - $empresasActivasAnterior) / $empresasActivasAnterior) * 100 
                : 100;

            // ========== KPI 3: Nuevas Empresas (período actual) ==========
            $nuevasEmpresas = Empresa::whereBetween('created_at', [$fechaInicio, $fechaFin])->count();
            $nuevasEmpresasAnterior = Empresa::whereBetween('created_at', [$fechaInicioAnterior, $fechaFinAnterior])->count();
            $crecimientoNuevasEmpresas = $nuevasEmpresasAnterior > 0 
                ? (($nuevasEmpresas - $nuevasEmpresasAnterior) / $nuevasEmpresasAnterior) * 100 
                : ($nuevasEmpresas > 0 ? 100 : 0);

            // ========== KPI 4: Tasa de Conversión a Planes Pagos ==========
            $totalEmpresas = Empresa::count();
            $empresasPago = Empresa::whereHas('plan', function($q) {
                $q->whereIn('slug', ['basico', 'premium']);
            })->count();
            
            $tasaConversion = $totalEmpresas > 0 ? ($empresasPago / $totalEmpresas) * 100 : 0;

            // ========== KPI 5: Ingresos Totales (acumulado) ==========
            $ingresosTotales = Suscripcion::where('estado', 'activa')
                ->sum('precio_pagado');
            
            $ingresosPeriodo = Suscripcion::where('estado', 'activa')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->sum('precio_pagado');
            
            $ingresosPeriodoAnterior = Suscripcion::where('estado', 'activa')
                ->whereBetween('created_at', [$fechaInicioAnterior, $fechaFinAnterior])
                ->sum('precio_pagado');
            
            $crecimientoIngresos = $ingresosPeriodoAnterior > 0 
                ? (($ingresosPeriodo - $ingresosPeriodoAnterior) / $ingresosPeriodoAnterior) * 100 
                : ($ingresosPeriodo > 0 ? 100 : 0);

            // ========== KPI 6: Actividad del Marketplace ==========
            $vistasPeriodo = Metrica::where('tipo', 'vista')
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->count();
            
            $clicsPeriodo = Metrica::whereIn('tipo', ['clic_telefono', 'clic_whatsapp', 'clic_sitio_web'])
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->count();
            
            $tasaInteraccion = $vistasPeriodo > 0 ? ($clicsPeriodo / $vistasPeriodo) * 100 : 0;

            // ========== KPI 7: Nuevos Clientes ==========
            $nuevosClientes = User::whereHas('role', function($q) {
                $q->where('name', 'cliente');
            })
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->count();
            
            $nuevosClientesAnterior = User::whereHas('role', function($q) {
                $q->where('name', 'cliente');
            })
            ->whereBetween('created_at', [$fechaInicioAnterior, $fechaFinAnterior])
            ->count();
            
            $crecimientoClientes = $nuevosClientesAnterior > 0 
                ? (($nuevosClientes - $nuevosClientesAnterior) / $nuevosClientesAnterior) * 100 
                : ($nuevosClientes > 0 ? 100 : 0);

            // ========== Distribución por Plan ==========
            $distribucionPlanes = [
                'gratis' => Empresa::whereHas('plan', function($q) {
                    $q->where('slug', 'gratis');
                })->count(),
                'basico' => Empresa::whereHas('plan', function($q) {
                    $q->where('slug', 'basico');
                })->count(),
                'premium' => Empresa::whereHas('plan', function($q) {
                    $q->where('slug', 'premium');
                })->count(),
            ];

            // ========== Gráfico de Evolución de Ingresos (últimos 12 meses) ==========
            $evolucionIngresos = [];
            for ($i = 11; $i >= 0; $i--) {
                $mesInicio = now()->subMonths($i)->startOfMonth();
                $mesFin = now()->subMonths($i)->endOfMonth();
                
                $ingresosMes = Suscripcion::where('estado', 'activa')
                    ->whereBetween('created_at', [$mesInicio, $mesFin])
                    ->sum('precio_pagado');
                
                $evolucionIngresos[] = [
                    'mes' => $mesInicio->format('M Y'),
                    'ingresos' => round($ingresosMes, 2)
                ];
            }

            // ========== Gráfico de Crecimiento de Empresas (últimos 12 meses) ==========
            $evolucionEmpresas = [];
            for ($i = 11; $i >= 0; $i--) {
                $mesInicio = now()->subMonths($i)->startOfMonth();
                $mesFin = now()->subMonths($i)->endOfMonth();
                
                $empresasMes = Empresa::whereBetween('created_at', [$mesInicio, $mesFin])->count();
                
                $evolucionEmpresas[] = [
                    'mes' => $mesInicio->format('M Y'),
                    'empresas' => $empresasMes
                ];
            }

            // ========== Alertas Críticas ==========
            $alertas = [];
            
            // Alerta: Churn alto (más de 5 empresas cancelaron este mes)
            $empresasCanceladas = Empresa::where('activo', false)
                ->whereBetween('updated_at', [now()->startOfMonth(), now()])
                ->count();
            
            if ($empresasCanceladas > 5) {
                $alertas[] = [
                    'tipo' => 'warning',
                    'mensaje' => "⚠️ {$empresasCanceladas} empresas se desactivaron este mes"
                ];
            }
            
            // Alerta: Conversión baja (menos del 10%)
            if ($tasaConversion < 10) {
                $alertas[] = [
                    'tipo' => 'danger',
                    'mensaje' => "🔴 Tasa de conversión baja: {$tasaConversion}%"
                ];
            }
            
            // Alerta: Empresas pendientes de aprobación
            $pendientes = Empresa::where('aprobado', false)->count();
            if ($pendientes > 10) {
                $alertas[] = [
                    'tipo' => 'info',
                    'mensaje' => "📋 {$pendientes} empresas esperando aprobación"
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    // KPIs Principales
                    'kpis' => [
                        'mrr' => round($mrr, 2),
                        'empresas_activas' => $empresasActivas,
                        'crecimiento_empresas' => round($crecimientoEmpresas, 1),
                        'nuevas_empresas' => $nuevasEmpresas,
                        'crecimiento_nuevas_empresas' => round($crecimientoNuevasEmpresas, 1),
                        'tasa_conversion' => round($tasaConversion, 1),
                        'ingresos_totales' => round($ingresosTotales, 2),
                        'ingresos_periodo' => round($ingresosPeriodo, 2),
                        'crecimiento_ingresos' => round($crecimientoIngresos, 1),
                        'vistas_periodo' => $vistasPeriodo,
                        'clics_periodo' => $clicsPeriodo,
                        'tasa_interaccion' => round($tasaInteraccion, 1),
                        'nuevos_clientes' => $nuevosClientes,
                        'crecimiento_clientes' => round($crecimientoClientes, 1),
                    ],
                    
                    // Distribuciones
                    'distribucion_planes' => $distribucionPlanes,
                    
                    // Gráficos
                    'evolucion_ingresos' => $evolucionIngresos,
                    'evolucion_empresas' => $evolucionEmpresas,
                    
                    // Alertas
                    'alertas' => $alertas,
                    
                    // Período
                    'periodo' => [
                        'fecha_inicio' => $fechaInicio,
                        'fecha_fin' => $fechaFin,
                        'dias' => $diasPeriodo,
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte ejecutivo',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}

