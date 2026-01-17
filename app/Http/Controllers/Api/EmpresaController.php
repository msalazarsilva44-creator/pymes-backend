<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Metrica;
use App\Models\Notification;
use App\Models\Suscripcion;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    /**
     * Listar empresas con búsqueda y filtros
     */
    public function index(Request $request)
    {
        $query = Empresa::with(['categoria', 'ciudad', 'municipio', 'plan'])
            ->where('activo', true)
            ->where('aprobado', true); // Solo empresas aprobadas

        // Filtro por ciudad
        if ($request->has('ciudad_id')) {
            $query->porCiudad($request->ciudad_id);
        }

        // Filtro por categoría
        if ($request->has('categoria_id')) {
            $query->porCategoria($request->categoria_id);
        }

        // Búsqueda por nombre
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_comercial', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        // Solo verificadas (opcional)
        if ($request->has('verificadas') && $request->verificadas) {
            $query->verificadas();
        }

        // Obtener todas las empresas y ordenar por plan en la colección
        $empresas = $query->get();
        
        // Ordenar por prioridad del plan (premium > basico > gratis)
        $empresas = $empresas->sortByDesc(function($empresa) {
            $planSlug = $empresa->plan->slug ?? 'gratis';
            $prioridades = ['premium' => 3, 'basico' => 2, 'gratis' => 1];
            return $prioridades[$planSlug] ?? 0;
        })->values();

        return response()->json([
            'success' => true,
            'data' => $empresas
        ], 200);
    }

    /**
     * Obtener detalle de una empresa
     */
    public function show($id, Request $request)
    {
        $empresa = Empresa::with([
            'categoria',
            'ciudad',
            'plan',
            'suscripcionActiva', // Incluir suscripción activa
            'fotos' => function($query) {
                $query->orderBy('es_principal', 'desc')->orderBy('orden', 'asc');
            },
            'servicios' => function($query) {
                $query->where('activo', true);
            },
            'horarios',
            'resenas' => function($query) {
                $query->visibles()->orderBy('created_at', 'desc')->take(10);
            },
            'resenas.user'
        ])->findOrFail($id);

        // Solo registrar vista si NO es el propietario viendo su propio perfil
        // Usar auth('sanctum')->user() porque la ruta es pública pero puede tener token
        $user = auth('sanctum')->user();
        $esPropietario = $user && $empresa->user_id === $user->id;
        
        // Si NO es el propietario (o es usuario no autenticado), contar la vista
        if (!$esPropietario) {
            // Registrar métrica de vista
            Metrica::create([
                'empresa_id' => $empresa->id,
                'user_id' => $user ? $user->id : null, // Guardar user_id si está autenticado
                'tipo' => 'vista',
                'fecha' => now()->toDateString(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'origen' => $request->header('X-Origin', 'web'),
            ]);

            // Incrementar contador de vistas
            $empresa->increment('total_vistas');

            // Detectar visitas repetidas y crear notificación
            if ($user) {
                // Solo para usuarios autenticados
                $this->detectarVisitasRepetidas($empresa, $user);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $empresa
        ], 200);
    }

    /**
     * Actualizar empresa (solo propietario)
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar que el usuario sea el propietario
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre_comercial' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'telefono' => 'sometimes|required|string|max:20',
            'email_contacto' => 'sometimes|required|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'sitio_web' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'direccion' => 'sometimes|required|string',
            'colonia' => 'nullable|string',
            'codigo_postal' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $empresa->update($request->only([
            'nombre_comercial',
            'descripcion',
            'telefono',
            'email_contacto',
            'whatsapp',
            'sitio_web',
            'facebook',
            'instagram',
            'twitter',
            'linkedin',
            'youtube',
            'tiktok',
            'direccion',
            'colonia',
            'codigo_postal',
            'activo',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Empresa actualizada exitosamente',
            'data' => $empresa->load(['categoria', 'ciudad', 'plan'])
        ], 200);
    }

    /**
     * Registrar clic (teléfono, whatsapp, sitio web)
     */
    public function registrarClic(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|in:clic_telefono,clic_whatsapp,clic_sitio_web,clic_direccion'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $empresa = Empresa::findOrFail($id);
        $user = auth('sanctum')->user();

        Metrica::create([
            'empresa_id' => $empresa->id,
            'user_id' => $user ? $user->id : null, // Guardar user_id si está autenticado
            'tipo' => $request->tipo,
            'fecha' => now()->toDateString(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'origen' => $request->header('X-Origin', 'web'),
        ]);

        // Incrementar contador de clics
        $empresa->increment('total_clics');

        return response()->json([
            'success' => true,
            'message' => 'Métrica registrada'
        ], 200);
    }

    /**
     * Obtener métricas de la empresa (solo propietario o admin)
     */
    public function metricas(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para ver estas métricas'
            ], 403);
        }

        $fechaInicio = $request->input('fecha_inicio', now()->subDays(30));
        $fechaFin = $request->input('fecha_fin', now());

        $metricas = Metrica::where('empresa_id', $empresa->id)
            ->porFechas($fechaInicio, $fechaFin)
            ->selectRaw('tipo, COUNT(*) as total, DATE(fecha) as fecha')
            ->groupBy('tipo', 'fecha')
            ->orderBy('fecha', 'desc')
            ->get();

        // Resumen
        $resumen = [
            'vistas_totales' => $empresa->total_vistas,
            'clics_totales' => $empresa->total_clics,
            'resenas_totales' => $empresa->total_resenas,
            'calificacion_promedio' => $empresa->calificacion_promedio,
            'periodo' => [
                'vistas' => $metricas->where('tipo', 'vista')->sum('total'),
                'clics_telefono' => $metricas->where('tipo', 'clic_telefono')->sum('total'),
                'clics_whatsapp' => $metricas->where('tipo', 'clic_whatsapp')->sum('total'),
                'clics_sitio_web' => $metricas->where('tipo', 'clic_sitio_web')->sum('total'),
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'resumen' => $resumen,
                'metricas' => $metricas,
            ]
        ], 200);
    }

    /**
     * Obtener horarios de la empresa
     */
    public function getHorarios(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        
        // SQLite no soporta FIELD(), usar ordenamiento compatible
        $horarios = $empresa->horarios()->get()->sortBy(function($horario) {
            $orden = [
                'Lunes' => 1,
                'Martes' => 2,
                'Miercoles' => 3,
                'Jueves' => 4,
                'Viernes' => 5,
                'Sabado' => 6,
                'Domingo' => 7
            ];
            return $orden[$horario->dia_semana] ?? 99;
        })->values();

        return response()->json([
            'success' => true,
            'data' => $horarios
        ], 200);
    }

    /**
     * Guardar horarios de la empresa
     */
    public function saveHorarios(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'horarios' => 'required|array',
            'horarios.*.dia_semana' => 'required|string|in:Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo',
            'horarios.*.hora_apertura' => 'required|date_format:H:i',
            'horarios.*.hora_cierre' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Eliminar horarios anteriores
        $empresa->horarios()->delete();

        // Crear nuevos horarios
        foreach ($request->horarios as $horario) {
            $empresa->horarios()->create([
                'dia_semana' => $horario['dia_semana'],
                'hora_apertura' => $horario['hora_apertura'],
                'hora_cierre' => $horario['hora_cierre'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Horarios guardados exitosamente',
            'data' => $empresa->horarios
        ], 200);
    }

    /**
     * Subir logo de la empresa
     */
    public function uploadLogo(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Eliminar logo anterior si existe
        if ($empresa->logo) {
            $oldLogoPath = str_replace('/storage/', '', $empresa->logo);
            if (Storage::disk('public')->exists($oldLogoPath)) {
                Storage::disk('public')->delete($oldLogoPath);
            }
        }

        // Guardar nuevo logo
        $file = $request->file('logo');
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('empresas/' . $empresa->id, $filename, 'public');

        $empresa->update([
            'logo' => '/storage/' . $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logo actualizado exitosamente',
            'data' => [
                'logo' => $empresa->logo
            ]
        ], 200);
    }

    /**
     * Eliminar logo de la empresa
     */
    public function deleteLogo(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        // Eliminar archivo físico
        if ($empresa->logo) {
            $logoPath = str_replace('/storage/', '', $empresa->logo);
            if (Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
        }

        $empresa->update([
            'logo' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logo eliminado exitosamente'
        ], 200);
    }

    /**
     * Subir banner de la empresa
     */
    public function uploadBanner(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Eliminar banner anterior si existe
        if ($empresa->banner) {
            $oldBannerPath = str_replace('/storage/', '', $empresa->banner);
            if (Storage::disk('public')->exists($oldBannerPath)) {
                Storage::disk('public')->delete($oldBannerPath);
            }
        }

        // Guardar nuevo banner
        $file = $request->file('banner');
        $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('empresas/' . $empresa->id, $filename, 'public');

        $empresa->update([
            'banner' => '/storage/' . $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner actualizado exitosamente',
            'data' => [
                'banner' => $empresa->banner
            ]
        ], 200);
    }

    /**
     * Eliminar banner de la empresa
     */
    public function deleteBanner(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        // Eliminar archivo físico
        if ($empresa->banner) {
            $bannerPath = str_replace('/storage/', '', $empresa->banner);
            if (Storage::disk('public')->exists($bannerPath)) {
                Storage::disk('public')->delete($bannerPath);
            }
        }

        $empresa->update([
            'banner' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner eliminado exitosamente'
        ], 200);
    }

    /**
     * Obtener fotos de la empresa
     */
    public function getFotos(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        $fotos = $empresa->fotos()->orderBy('es_principal', 'desc')->orderBy('orden', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $fotos
        ], 200);
    }

    /**
     * Subir foto
     */
    public function uploadFoto(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        // Contar fotos existentes
        $totalFotos = $empresa->fotos()->count();

        // Verificar límite de fotos (10 por empresa)
        if ($totalFotos >= 10) {
            return response()->json([
                'success' => false,
                'message' => 'Has alcanzado el límite de 10 fotos por empresa'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'descripcion' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Guardar foto
        $file = $request->file('foto');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('empresas/' . $empresa->id, $filename, 'public');

        $foto = $empresa->fotos()->create([
            'url' => '/storage/' . $path,
            'descripcion' => $request->descripcion,
            'orden' => $totalFotos + 1,
            'es_principal' => $totalFotos === 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto subida exitosamente',
            'data' => $foto
        ], 201);
    }

    /**
     * Eliminar foto
     */
    public function deleteFoto(Request $request, $id, $fotoId)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $foto = $empresa->fotos()->findOrFail($fotoId);
        
        // Eliminar archivo físico
        $filePath = str_replace('/storage/', '', $foto->url);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $foto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto eliminada exitosamente'
        ], 200);
    }

    /**
     * Obtener servicios de la empresa
     */
    public function getServicios(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        $servicios = $empresa->servicios()->where('activo', true)->orderBy('orden', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $servicios
        ], 200);
    }

    /**
     * Crear servicio
     */
    public function createServicio(Request $request, $id)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $servicio = $empresa->servicios()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'activo' => true,
            'orden' => $empresa->servicios()->count() + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Servicio creado exitosamente',
            'data' => $servicio
        ], 201);
    }

    /**
     * Actualizar servicio
     */
    public function updateServicio(Request $request, $id, $servicioId)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $servicio = $empresa->servicios()->findOrFail($servicioId);

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $servicio->update($request->only(['nombre', 'descripcion', 'precio']));

        return response()->json([
            'success' => true,
            'message' => 'Servicio actualizado exitosamente',
            'data' => $servicio
        ], 200);
    }

    /**
     * Eliminar servicio
     */
    public function deleteServicio(Request $request, $id, $servicioId)
    {
        $user = $request->user();
        $empresa = Empresa::findOrFail($id);

        // Verificar permisos
        if ($empresa->user_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para editar esta empresa'
            ], 403);
        }

        $servicio = $empresa->servicios()->findOrFail($servicioId);
        $servicio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Servicio eliminado exitosamente'
        ], 200);
    }

    /**
     * Verificar o rechazar empresa (Solo Admin)
     */
    public function verificarEmpresa(Request $request, $id)
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

        $empresa = Empresa::with(['user'])->findOrFail($id);

        if ($request->accion === 'aprobar') {
            $empresa->update([
                'verificado' => true,
                'verificado_at' => now(),
                'activo' => true,
                'motivo_suspension' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Empresa aprobada exitosamente',
                'data' => $empresa
            ], 200);

        } else { // rechazar
            $empresa->update([
                'verificado' => false,
                'verificado_at' => null,
                'activo' => false,
                'motivo_suspension' => $request->motivo,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Empresa rechazada. Se ha guardado el motivo del rechazo.',
                'data' => $empresa
            ], 200);
        }
    }

    /**
     * Listar empresas pendientes de aprobación (Solo Admin)
     */
    public function empresasPendientes(Request $request)
    {
        $empresas = Empresa::with(['categoria', 'ciudad', 'municipio', 'plan', 'user'])
            ->pendientes()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $empresas
        ], 200);
    }

    /**
     * Aprobar o rechazar empresa (Solo Admin)
     */
    public function aprobarEmpresa(Request $request, $id)
    {
        $user = $request->user();
        
        // Verificar que el usuario sea admin
        if (!$user || !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para realizar esta acción'
            ], 403);
        }

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

        $empresa = Empresa::with(['user'])->findOrFail($id);

        if ($request->accion === 'aprobar') {
            $empresa->update([
                'aprobado' => true,
                'aprobado_at' => now(),
                'aprobado_por' => $user->id,
                'activo' => true,
                'motivo_rechazo' => null,
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
                'aprobado_por' => $user->id,
                'activo' => false,
                'motivo_rechazo' => $request->motivo,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Empresa rechazada. Se ha notificado al usuario.',
                'data' => $empresa
            ], 200);
        }
    }

    /**
     * Detectar visitas repetidas y crear notificación
     */
    private function detectarVisitasRepetidas(Empresa $empresa, $user)
    {
        // Contar vistas del usuario específico en los últimos 30 días
        $visitas = Metrica::where('empresa_id', $empresa->id)
            ->where('tipo', 'vista')
            ->where('fecha', '>=', now()->subDays(30))
            ->where('user_id', $user->id) // Ahora contamos por user_id
            ->count();

        // Si tiene 2 o más visitas, gestionar notificación
        if ($visitas >= 2) {
            // Verificar que no exista ya una notificación similar reciente
            $nombreUsuario = $user->name;
            $notificacionExistente = Notification::where('empresa_id', $empresa->id)
                ->where('tipo', 'visitas_repetidas')
                ->where('mensaje', 'LIKE', "%{$nombreUsuario}%")
                ->where('created_at', '>=', now()->subDays(7))
                ->first(); // Cambiado a first() para obtener la notificación si existe

            if (!$notificacionExistente) {
                // Crear nueva notificación
                $titulo = $visitas == 2 ? '🔥 Cliente Interesado' : '🔥🔥 ¡Cliente Muy Interesado!';
                $mensaje = $visitas == 2 
                    ? sprintf('%s ha visitado tu perfil 2 veces. ¡Podría estar interesado en tus servicios!', $user->name)
                    : sprintf('%s ha visitado tu perfil %d veces. ¡Definitivamente está interesado!', $user->name, $visitas);

                $notificacion = Notification::create([
                    'empresa_id' => $empresa->id,
                    'tipo' => 'visitas_repetidas',
                    'titulo' => $titulo,
                    'mensaje' => $mensaje,
                    'data' => [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'visitas' => $visitas,
                        'fecha' => now()->toDateTimeString(),
                    ],
                    'leida' => false,
                ]);
            } else {
                // Actualizar notificación existente si hay más visitas
                $titulo = $visitas <= 2 ? '🔥 Cliente Interesado' : '🔥🔥 ¡Cliente Muy Interesado!';
                $mensaje = $visitas <= 2 
                    ? sprintf('%s ha visitado tu perfil 2 veces. ¡Podría estar interesado en tus servicios!', $user->name)
                    : sprintf('%s ha visitado tu perfil %d veces. ¡Definitivamente está interesado!', $user->name, $visitas);

                $notificacionExistente->update([
                    'titulo' => $titulo,
                    'mensaje' => $mensaje,
                    'data' => array_merge($notificacionExistente->data ?? [], [
                        'visitas' => $visitas,
                        'ultima_visita' => now()->toDateTimeString(),
                    ]),
                    'leida' => false, // Marcar como no leída de nuevo
                ]);
            }
        }

    }

    /**
     * Solicitar una suscripción de plan pago (Básico o Premium)
     */
    public function solicitarSuscripcion(Request $request)
    {
        try {
            // Validar datos
            $validator = Validator::make($request->all(), [
                'plan_id' => 'required|exists:planes,id',
                'tipo_periodo' => 'required|in:mensual,anual',
                'metodo_pago' => 'required|in:banco,binance,paypal,zelle', // NUEVO
                'capture_pago' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Máx 5MB
                'referencia_bancaria' => 'required|string|min:4|max:50',
                'fecha_pago' => 'required|date|before_or_equal:today',
                'nombre_empresa_pagadora' => 'required|string|max:255',
                'rif_pagador' => 'required|string|max:20',
            ], [
                'plan_id.required' => 'Debes seleccionar un plan',
                'plan_id.exists' => 'El plan seleccionado no existe',
                'tipo_periodo.required' => 'Debes seleccionar un periodo',
                'tipo_periodo.in' => 'El periodo debe ser mensual o anual',
                'metodo_pago.required' => 'Debes seleccionar un método de pago', // NUEVO
                'metodo_pago.in' => 'El método de pago seleccionado no es válido', // NUEVO
                'capture_pago.required' => 'Debes subir el capture del pago',
                'capture_pago.image' => 'El capture debe ser una imagen',
                'capture_pago.max' => 'La imagen no puede exceder 5MB',
                'referencia_bancaria.required' => 'La referencia/ID de transacción es obligatoria',
                'referencia_bancaria.min' => 'La referencia debe tener al menos 4 caracteres',
                'fecha_pago.required' => 'La fecha de pago es obligatoria',
                'fecha_pago.date' => 'La fecha de pago no es válida',
                'fecha_pago.before_or_equal' => 'La fecha de pago no puede ser futura',
                'nombre_empresa_pagadora.required' => 'El nombre del pagador es obligatorio',
                'rif_pagador.required' => 'El RIF del pagador es obligatorio',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Obtener empresa autenticada
            $user = auth()->user();
            $empresa = Empresa::where('user_id', $user->id)->first();

            if (!$empresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la empresa asociada a este usuario'
                ], 404);
            }

            // Verificar que no tenga una suscripción pendiente
            $suscripcionPendiente = Suscripcion::where('empresa_id', $empresa->id)
                ->where('estado', 'pendiente_aprobacion')
                ->first();

            if ($suscripcionPendiente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tienes una solicitud de suscripción pendiente de aprobación'
                ], 400);
            }

            // Obtener plan
            $plan = Plan::findOrFail($request->plan_id);

            // Verificar que el plan sea de pago (no gratis)
            if ($plan->slug === 'gratis') {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes solicitar aprobación para el plan gratuito'
                ], 400);
            }

            // Calcular precio según el periodo
            $precio = $request->tipo_periodo === 'mensual' 
                ? $plan->precio_mensual 
                : $plan->precio_anual;

            // Subir capture de pago
            $capturePath = $request->file('capture_pago')->store('captures_pago', 'public');

            // Crear solicitud de suscripción
            $suscripcion = Suscripcion::create([
                'empresa_id' => $empresa->id,
                'plan_id' => $plan->id,
                'tipo_periodo' => $request->tipo_periodo,
                'metodo_pago' => $request->metodo_pago, // NUEVO
                'precio_pagado' => $precio,
                'estado' => 'pendiente_aprobacion',
                'capture_pago' => $capturePath,
                'referencia_bancaria' => $request->referencia_bancaria,
                'fecha_pago' => $request->fecha_pago,
                'nombre_empresa_pagadora' => $request->nombre_empresa_pagadora,
                'rif_pagador' => $request->rif_pagador,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solicitud de suscripción enviada exitosamente. Un administrador la revisará pronto.',
                'suscripcion' => $suscripcion->load('plan')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage(), // Siempre mostrar el error para debugging
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}

