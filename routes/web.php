<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\WebAuthController;

// Landing Page
Route::get('/', function () {
    return view('landing');
});

Route::get('/landing', function () {
    return view('landing');
});

// Auth
Route::get('/registro', function () {
    return view('registro');
});

Route::get('/login', function () {
    return view('login');
});

// Marketplace Público
Route::get('/marketplace', function () {
    return view('marketplace');
});

// Planes y Precios
Route::get('/planes', function () {
    return view('planes');
});

// Dashboard Cliente (Index tipo Mercado Libre)
Route::get('/dashboard/cliente', function () {
    return view('index-cliente');
});

// Dashboard Empresa
Route::get('/dashboard/empresa', function () {
    return view('dashboard-empresa');
});

// ==================== RUTAS DE ADMIN (PROTEGIDAS) ====================
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard/admin', function () {
        return view('dashboard-admin');
    })->name('admin.dashboard');
    
    // Módulos de Admin
    Route::get('/admin/empresas-pendientes', function () {
        return view('admin.empresas-pendientes');
    })->name('admin.empresas-pendientes');
    
    Route::get('/admin/empresas', function () {
        return view('admin.empresas');
    })->name('admin.empresas');
    
    Route::get('/admin/suscripciones-pendientes', function () {
        return view('admin.suscripciones-pendientes');
    })->name('admin.suscripciones-pendientes');
    
    Route::get('/admin/categorias', function () {
        return view('admin.categorias');
    })->name('admin.categorias');
    
    Route::get('/admin/reportes', function () {
        return view('admin.reportes');
    })->name('admin.reportes');
    
});

// ==================== API ADMIN CON SANCTUM (Bearer Token) ====================
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin/api')->name('admin.api.')->group(function () {
    
    // Estadísticas del dashboard
    Route::get('/stats', [App\Http\Controllers\AdminController::class, 'getStats'])->name('stats');
    
    // Gestión de Empresas (rutas específicas primero para evitar conflictos)
    Route::get('/empresas/lista', [App\Http\Controllers\AdminController::class, 'listarEmpresasGestion'])->name('empresas.lista');
    Route::get('/empresas/pendientes', [App\Http\Controllers\AdminController::class, 'empresasPendientes'])->name('empresas.pendientes');
    Route::get('/empresas', [App\Http\Controllers\AdminController::class, 'getEmpresas'])->name('empresas.index');
    Route::get('/empresas/{id}', [App\Http\Controllers\AdminController::class, 'getEmpresa'])->name('empresas.show');
    Route::post('/empresas/{id}/aprobar', [App\Http\Controllers\AdminController::class, 'aprobarEmpresa'])->name('empresas.aprobar');
    Route::post('/empresas/{id}/toggle-estado', [App\Http\Controllers\AdminController::class, 'toggleEmpresaEstado'])->name('empresas.toggle');
    Route::post('/empresas/{id}/penalizar', [App\Http\Controllers\AdminController::class, 'penalizarEmpresa'])->name('empresas.penalizar');
    Route::post('/empresas/{id}/quitar-penalizacion', [App\Http\Controllers\AdminController::class, 'quitarPenalizacion'])->name('empresas.quitar-penalizacion');
    Route::delete('/empresas/{id}', [App\Http\Controllers\AdminController::class, 'eliminarEmpresa'])->name('empresas.eliminar');
    
    // Gestión de Usuarios
    Route::get('/usuarios', [App\Http\Controllers\AdminController::class, 'getUsuarios'])->name('usuarios.index');
    
    // Gestión de Suscripciones
    Route::get('/suscripciones/pendientes', [App\Http\Controllers\AdminController::class, 'suscripcionesPendientes'])->name('suscripciones.pendientes');
    Route::post('/suscripciones/{id}/aprobar', [App\Http\Controllers\AdminController::class, 'aprobarSuscripcion'])->name('suscripciones.aprobar');
    Route::post('/suscripciones/{id}/rechazar', [App\Http\Controllers\AdminController::class, 'rechazarSuscripcion'])->name('suscripciones.rechazar');
    
    // Gestión de Categorías
    Route::get('/categorias', [App\Http\Controllers\AdminController::class, 'getCategorias'])->name('categorias.index');
    Route::get('/categorias/{id}', [App\Http\Controllers\AdminController::class, 'getCategoria'])->name('categorias.show');
    Route::post('/categorias', [App\Http\Controllers\AdminController::class, 'crearCategoria'])->name('categorias.store');
    Route::put('/categorias/{id}', [App\Http\Controllers\AdminController::class, 'actualizarCategoria'])->name('categorias.update');
    Route::delete('/categorias/{id}', [App\Http\Controllers\AdminController::class, 'eliminarCategoria'])->name('categorias.destroy');
    Route::post('/categorias/{id}/toggle-estado', [App\Http\Controllers\AdminController::class, 'toggleCategoriaEstado'])->name('categorias.toggle');
    
    // Reportes
    Route::get('/reportes/ejecutivo', [App\Http\Controllers\AdminController::class, 'reporteEjecutivo'])->name('reportes.ejecutivo');
    
});

// Módulos de Empresa
Route::get('/empresa/editar-perfil', function () {
    return view('empresa.editar-perfil');
});

Route::get('/empresa/solicitar-plan', function () {
    return view('empresa.solicitar-plan');
});

Route::get('/empresa/galeria', function () {
    return view('empresa.galeria');
});

Route::get('/empresa/horarios', function () {
    return view('empresa.horarios');
});

Route::get('/empresa/servicios', function () {
    return view('empresa.servicios');
});

Route::get('/empresa/metricas', function () {
    return view('empresa.metricas');
});

Route::get('/empresa/resenas', function () {
    return view('empresa.resenas');
});

// Páginas de Cliente
Route::get('/perfil', function () {
    return view('perfil-cliente');
});

Route::get('/favoritos', function () {
    return view('favoritos');
});

Route::get('/mis-compras', function () {
    return view('mis-compras');
});

Route::get('/ofertas', function () {
    return view('ofertas');
});

Route::get('/ayuda', function () {
    return view('ayuda');
});

// Perfil Público de Empresa
Route::get('/perfil-empresa/{id}', function ($id) {
    return view('perfil-empresa');
});

// Servir archivos de storage (alternativa a symbolic link)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($filePath);
    return response()->file($filePath, [
        'Content-Type' => $mimeType
    ]);
})->where('path', '.*');

// Autenticación Web
Route::post('/web/login', [WebAuthController::class, 'login'])->name('web.login');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

