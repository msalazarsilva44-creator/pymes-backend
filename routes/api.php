<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CiudadController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ResenaController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\OrdenController;
use App\Http\Controllers\Api\MetodoPagoController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\ReporteController;
use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\Api\AdminMembresiaController;

/*
|--------------------------------------------------------------------------
| API Routes - ServiLocal
|--------------------------------------------------------------------------
*/

// ==================== RUTAS PÚBLICAS ====================

// Autenticación
Route::post('/auth/register/cliente', [AuthController::class, 'registerCliente']);
Route::post('/auth/register/empresa', [AuthController::class, 'registerEmpresa']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'login']);

// Categorías
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/{id}', [CategoriaController::class, 'show']);

// Ciudades
Route::get('/ciudades', [CiudadController::class, 'index']);
Route::get('/ciudades/{id}', [CiudadController::class, 'show']);

// Municipios
Route::get('/municipios/{ciudadId}', [CiudadController::class, 'getMunicipios']);

// Planes
Route::get('/planes', [PlanController::class, 'index']);
Route::get('/planes/{id}', [PlanController::class, 'show']);

// Membresías activas (público — consumido por PagoEmpresa.tsx)
Route::get('/membresias/activas', [AdminMembresiaController::class, 'activas']);

// Empresas
Route::get('/empresas', [EmpresaController::class, 'index']);
Route::get('/empresas/con-servicios', [EmpresaController::class, 'empresasConServicios']);
Route::get('/empresas/{id}', [EmpresaController::class, 'show']);
Route::post('/empresas/{id}/clic', [EmpresaController::class, 'registrarClic']);

// Productos y Servicios (Marketplace)
Route::get('/productos/todos', [EmpresaController::class, 'getAllProductos']);
Route::get('/servicios/todos', [PlanController::class, 'getAllServicios']);

// Ruta de prueba
Route::get('/test', function() {
    return response()->json(['test' => 'working']);
});

// Reseñas
Route::get('/empresas/{empresaId}/resenas', [ResenaController::class, 'index']);

// Métodos de pago de empresa (público - para checkout)
Route::get('/empresas/{empresaId}/metodos-pago', [MetodoPagoController::class, 'getByEmpresa']);

// ==================== RUTAS PROTEGIDAS ====================

Route::middleware('auth:sanctum')->group(function () {
    
    // Autenticación
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);

    // Cliente
    Route::get('/cliente/perfil', [ClienteController::class, 'perfil']);
    Route::put('/cliente/perfil', [ClienteController::class, 'actualizar']);

    // Empresas (solo propietario)
    Route::put('/empresas/{id}', [EmpresaController::class, 'update']);
    Route::get('/empresas/{id}/metricas', [EmpresaController::class, 'metricas']);
    
    // Suscripciones (empresa solicita plan)
    Route::post('/suscripciones/solicitar', [EmpresaController::class, 'solicitarSuscripcion']);

    // Horarios de Empresa
    Route::get('/empresas/{id}/horarios', [EmpresaController::class, 'getHorarios']);
    Route::post('/empresas/{id}/horarios', [EmpresaController::class, 'saveHorarios']);

    // Logo de Empresa
    Route::post('/empresas/{id}/logo', [EmpresaController::class, 'uploadLogo']);
    Route::delete('/empresas/{id}/logo', [EmpresaController::class, 'deleteLogo']);

    // Banner de Empresa
    Route::post('/empresas/{id}/banner', [EmpresaController::class, 'uploadBanner']);
    Route::delete('/empresas/{id}/banner', [EmpresaController::class, 'deleteBanner']);

    // Galería de Empresa
    Route::get('/empresas/{id}/fotos', [EmpresaController::class, 'getFotos']);
    Route::post('/empresas/{id}/fotos', [EmpresaController::class, 'uploadFoto']);
    Route::delete('/empresas/{id}/fotos/{fotoId}', [EmpresaController::class, 'deleteFoto']);

    // Servicios de Empresa
    Route::get('/empresas/{id}/servicios', [EmpresaController::class, 'getServicios']);
    Route::post('/empresas/{id}/servicios', [EmpresaController::class, 'createServicio']);
    Route::put('/empresas/{id}/servicios/{servicioId}', [EmpresaController::class, 'updateServicio']);
    Route::delete('/empresas/{id}/servicios/{servicioId}', [EmpresaController::class, 'deleteServicio']);
    Route::post('/empresas/{id}/servicios/{servicioId}/imagenes', [EmpresaController::class, 'uploadServicioImagen']);
    Route::delete('/empresas/{id}/servicios/{servicioId}/imagenes/{imagenId}', [EmpresaController::class, 'deleteServicioImagen']);

    // Productos de Empresa
    Route::get('/empresas/{id}/productos', [EmpresaController::class, 'getProductos']);
    Route::post('/empresas/{id}/productos', [EmpresaController::class, 'createProducto']);
    Route::put('/empresas/{id}/productos/{productoId}', [EmpresaController::class, 'updateProducto']);
    Route::delete('/empresas/{id}/productos/{productoId}', [EmpresaController::class, 'deleteProducto']);
    Route::post('/empresas/{id}/productos/{productoId}/imagenes', [EmpresaController::class, 'uploadProductoImagen']);
    Route::delete('/empresas/{id}/productos/{productoId}/imagenes/{imagenId}', [EmpresaController::class, 'deleteProductoImagen']);

    // Reseñas (cliente autenticado)
    Route::post('/empresas/{empresaId}/resenas', [ResenaController::class, 'store']);
    Route::post('/resenas/{id}/responder', [ResenaController::class, 'responder']);

    // Admin - Verificación de Empresas
    Route::post('/admin/empresas/{id}/verificar', [EmpresaController::class, 'verificarEmpresa']);
    
    // Admin - Aprobación de Empresas
    Route::get('/admin/empresas/pendientes', [EmpresaController::class, 'empresasPendientes']);
    Route::post('/admin/empresas/{id}/aprobar', [EmpresaController::class, 'aprobarEmpresa']);

    // Notificaciones
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/marcar-leida', [NotificationController::class, 'marcarLeida']);
    Route::post('/notifications/marcar-todas-leidas', [NotificationController::class, 'marcarTodasLeidas']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    // ==================== CARRITO DE COMPRAS ====================
    
    // Carrito (clientes)
    Route::get('/carrito', [CarritoController::class, 'index']);
    Route::get('/carrito/count', [CarritoController::class, 'count']);
    Route::post('/carrito', [CarritoController::class, 'store']);
    Route::put('/carrito/{id}', [CarritoController::class, 'actualizarCantidad']);
    Route::delete('/carrito/{id}', [CarritoController::class, 'destroy']);
    Route::delete('/carrito', [CarritoController::class, 'clear']);
    Route::delete('/carrito/empresa/{empresaId}', [CarritoController::class, 'clearEmpresa']);

    // Órdenes (clientes)
    Route::post('/ordenes', [OrdenController::class, 'store']);
    Route::get('/mis-ordenes', [OrdenController::class, 'misOrdenes']);
    Route::get('/ordenes/{id}', [OrdenController::class, 'show']);
    Route::post('/ordenes/{id}/comprobante', [OrdenController::class, 'subirComprobante']);
    Route::put('/ordenes/{id}/cancelar', [OrdenController::class, 'cancelar']);

    // Órdenes (empresa)
    Route::get('/empresa/ordenes', [OrdenController::class, 'ordenesEmpresa']);
    Route::put('/empresa/ordenes/{id}/confirmar', [OrdenController::class, 'confirmar']);
    Route::put('/empresa/ordenes/{id}/completar', [OrdenController::class, 'completar']);

    // Inventario (empresa)
    Route::post('/empresa/productos/ingreso', [InventarioController::class, 'ingreso']);

    // Reportes (empresa)
    Route::get('/empresa/reportes/ventas', [ReporteController::class, 'ventas']);
    Route::get('/empresa/reportes/ingresos-dia', [ReporteController::class, 'ingresosPorDia']);

    // Métodos de Pago (empresa)
    Route::get('/empresa/metodos-pago', [MetodoPagoController::class, 'index']);
    Route::post('/empresa/metodos-pago', [MetodoPagoController::class, 'store']);
    Route::delete('/empresa/metodos-pago/{tipo}', [MetodoPagoController::class, 'destroy']);

    // Reportes Admin
    Route::get('/admin/reportes/ventas', [OrdenController::class, 'reportesAdmin']);

    // Dashboard Admin
    Route::get('/admin/dashboard', function() {
        $totalUsuarios = \App\Models\User::count();
        $totalEmpresas = \App\Models\Empresa::count();
        $totalServicios = \App\Models\Servicio::count();
        $nuevosHoy = \App\Models\User::whereDate('created_at', today())->count();
        
        return response()->json([
            'total_usuarios' => $totalUsuarios,
            'total_empresas' => $totalEmpresas,
            'total_servicios' => $totalServicios,
            'nuevos_hoy' => $nuevosHoy
        ]);
    });

    // Admin - Usuarios
    Route::get('/admin/usuarios', function() {
        $usuarios = \App\Models\User::with('role')->get();
        return response()->json(['data' => $usuarios]);
    });

    // Admin - Empresas
    Route::get('/admin/empresas', function() {
        $empresas = \App\Models\Empresa::with(['user', 'categoria', 'ciudad'])->get();
        return response()->json(['data' => $empresas]);
    });

    // Admin - Servicios
    Route::get('/admin/servicios', function() {
        $servicios = \App\Models\Servicio::with('empresa')->get();
        return response()->json(['data' => $servicios]);
    });

    // Admin - Membresías (CRUD sobre tabla planes)
    Route::get('/admin/membresias', [AdminMembresiaController::class, 'index']);
    Route::post('/admin/membresias', [AdminMembresiaController::class, 'store']);
    Route::put('/admin/membresias/{id}', [AdminMembresiaController::class, 'update']);
    Route::delete('/admin/membresias/{id}', [AdminMembresiaController::class, 'destroy']);
    Route::patch('/admin/membresias/{id}/toggle', [AdminMembresiaController::class, 'toggle']);

});

// Ruta de prueba
Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'ServiLocal API funcionando correctamente',
        'version' => '1.0.0',
        'timestamp' => now()
    ]);
});

