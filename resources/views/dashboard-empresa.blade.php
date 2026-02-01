<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Proveedor - MERCAROF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'mercarof-navy': '#003B5C',
                        'mercarof-navy-dark': '#002942',
                        'mercarof-navy-light': '#004D73',
                        'mercarof-cyan': '#00A3E0',
                        'mercarof-cyan-dark': '#0082B8',
                        'mercarof-cyan-light': '#33B8E8',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%);
        }
        .main-bg {
            background-color: #f3f4f6;
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .logo-container img {
            height: 32px;
            width: auto;
        }
    </style>
</head>
<body class="main-bg">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-4">
                    <div class="logo-container">
                        <img src="/logo-mercarof.jpeg" alt="MERCAROF Logo">
                        <a href="#" id="logo-home" class="text-xl font-bold text-mercarof-navy cursor-pointer">MERCAROF</a>
                    </div>
                    <span class="text-sm text-gray-500">/ Dashboard Proveedor</span>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Notificaciones -->
                    <div class="relative">
                        <button onclick="toggleNotificaciones()" class="relative p-2 text-gray-600 hover:text-mercarof-cyan transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span id="badge-notificaciones" class="hidden absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 items-center justify-center"></span>
                        </button>
                        
                        <!-- Dropdown de notificaciones -->
                        <div id="dropdown-notificaciones" class="hidden absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 z-50 max-h-96 overflow-y-auto">
                            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="font-bold text-gray-900">Notificaciones</h3>
                                <button onclick="marcarTodasLeidas()" class="text-xs text-mercarof-cyan hover:text-mercarof-cyan-dark font-medium">
                                    Marcar todas leídas
                                </button>
                            </div>
                            <div id="lista-notificaciones" class="divide-y divide-gray-100">
                                <!-- Se llenará dinámicamente -->
                            </div>
                        </div>
                    </div>
                    
                    <span class="text-sm text-gray-600" id="empresa-name"></span>
                    <button onclick="cerrarSesion()" class="text-sm text-red-600 hover:text-red-700 font-medium">
                        Cerrar Sesión
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header con Info de Plan -->
        <div class="gradient-bg rounded-lg p-6 text-white mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold mb-2">¡Hola! 👋</h2>
                    <p class="text-mercarof-cyan-light" id="empresa-descripcion">Gestiona tu negocio en MERCAROF</p>
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                    <p class="text-sm text-mercarof-cyan-light mb-1">Plan Actual</p>
                    <p class="text-2xl font-bold mb-2" id="plan-name">Gratis</p>
                    
                    <!-- Información de suscripción para planes pagos -->
                    <div id="suscripcion-info" class="mb-3 pb-3 border-b border-white/30" style="display: none;">
                        <div class="bg-white/10 rounded-lg p-3 mb-2">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-2xl">⏰</span>
                                <div class="flex-1">
                                    <span id="dias-restantes" class="text-base font-bold block"></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-mercarof-cyan-light">
                                <span>📅</span>
                                <span>Vence: <span id="fecha-vencimiento" class="font-semibold"></span></span>
                            </div>
                        </div>
                        <a href="/empresa/solicitar-plan" class="text-xs text-white hover:text-mercarof-cyan-light underline block text-center">
                            🔄 Renovar ahora
                        </a>
                    </div>
                    
                    <a href="/planes" class="text-sm text-white hover:text-mercarof-cyan-light underline inline-block">Mejorar Plan →</a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">👁️</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Vistas Totales</p>
                        <p class="text-2xl font-bold text-gray-900" id="stat-vistas">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">📞</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Clics Totales</p>
                        <p class="text-2xl font-bold text-gray-900" id="stat-clics">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Calificación</p>
                        <p class="text-2xl font-bold text-gray-900" id="stat-calificacion">0.0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all cursor-pointer" onclick="window.location.href='/empresa/resenas'">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-mercarof-cyan bg-opacity-10 rounded-lg flex items-center justify-center relative">
                        <span class="text-2xl">💬</span>
                        <span id="badge-resenas-pendientes" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 items-center justify-center"></span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Reseñas</p>
                        <p class="text-2xl font-bold text-gray-900" id="stat-resenas">0</p>
                        <p class="text-xs text-orange-600 font-semibold" id="text-pendientes" style="display:none;"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado de Aprobación -->
        <div id="alerta-aprobacion" class="hidden bg-orange-50 border-l-4 border-orange-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="text-2xl">⏳</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-orange-700">
                        <strong>Tu empresa está pendiente de aprobación.</strong> 
                        Un administrador revisará tu información pronto. Una vez aprobada, podrás publicar tu empresa y aparecer en el marketplace.
                    </p>
                </div>
            </div>
        </div>

        <!-- Estado de Verificación -->
        <div id="alerta-verificacion" class="hidden bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="text-2xl">⚠️</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Tu perfil aún no está verificado.</strong> 
                        Completa tu perfil y envía tus documentos para obtener la verificación y aumentar tu credibilidad.
                    </p>
                </div>
            </div>
        </div>

        <!-- Métricas Destacadas (Solo para planes Básico y Premium) -->
        <div id="seccion-metricas" class="bg-gradient-to-r from-mercarof-navy via-mercarof-cyan to-mercarof-cyan-light rounded-lg shadow-lg p-6 mb-8 text-white" style="display: none;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex-1">
                    <h3 class="text-2xl font-bold mb-2">📊 Analiza el Desempeño de tu Empresa</h3>
                    <p class="text-mercarof-cyan-light text-sm mb-4">Descubre cómo los clientes interactúan con tu perfil, obtén insights valiosos y toma decisiones basadas en datos.</p>
                    <div class="flex gap-4 text-sm">
                        <div>
                            <p class="text-mercarof-cyan-light">Vistas este mes</p>
                            <p class="text-2xl font-bold" id="preview-vistas">-</p>
                        </div>
                        <div>
                            <p class="text-mercarof-cyan-light">Clics este mes</p>
                            <p class="text-2xl font-bold" id="preview-clics">-</p>
                        </div>
                        <div>
                            <p class="text-mercarof-cyan-light">Conversión</p>
                            <p class="text-2xl font-bold" id="preview-conversion">-%</p>
                        </div>
                    </div>
                </div>
                <a href="/empresa/metricas" class="bg-white text-mercarof-cyan font-bold py-3 px-8 rounded-lg border-2 border-mercarof-cyan hover:bg-gray-50 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                    <span>📈</span>
                    Ver Métricas Completas
                </a>
            </div>
        </div>

        <!-- CTA para mejorar plan (Solo para plan gratis) -->
        <div id="cta-mejorar-plan" class="bg-gradient-to-r from-orange-500 to-pink-600 rounded-lg shadow-lg p-8 mb-8 text-white" style="display: none;">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold mb-2">🚀 Desbloquea el Panel de Métricas</h3>
                    <p class="text-white/90">Obtén insights valiosos sobre tu negocio con métricas detalladas, gráficos y notificaciones de clientes interesados.</p>
                </div>
                <a href="/planes" class="bg-white text-orange-600 font-bold py-3 px-8 rounded-lg hover:bg-orange-50 transition-all shadow-lg hover:shadow-xl whitespace-nowrap">
                    Ver Planes
                </a>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Gestión Rápida</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <a href="/empresa/editar-perfil" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">✏️</span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Editar Perfil</p>
                        <p class="text-sm text-gray-600">Actualizar información</p>
                    </div>
                </a>

                <a href="/empresa/galeria" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">📸</span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Galería</p>
                        <p class="text-sm text-gray-600">Gestionar fotos</p>
                    </div>
                </a>

                <button onclick="abrirModalBanner()" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all text-left">
                    <span class="text-2xl">🖼️</span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Banner</p>
                        <p class="text-sm text-gray-600">Personalizar banner</p>
                    </div>
                </button>

                <a href="/empresa/horarios" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">🕐</span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Horarios</p>
                        <p class="text-sm text-gray-600">Configurar horarios</p>
                    </div>
                </a>

                <a href="/empresa/servicios" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">💼</span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Servicios</p>
                        <p class="text-sm text-gray-600">Gestionar servicios</p>
                    </div>
                </a>

                <a href="/empresa/resenas" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all relative">
                    <span class="text-2xl">💬</span>
                    <span id="badge-resenas-quick" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1"></span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Reseñas</p>
                        <p class="text-sm text-gray-600">Responder clientes</p>
                    </div>
                </a>

                <a href="/empresa/metodos-pago" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">💳</span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Métodos de Pago</p>
                        <p class="text-sm text-gray-600">Configurar pagos</p>
                    </div>
                </a>

                <a href="/empresa/ventas" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all relative">
                    <span class="text-2xl">📊</span>
                    <span id="badge-ordenes-pendientes" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1 flex items-center justify-center"></span>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Ventas</p>
                        <p class="text-sm text-gray-600">Órdenes y reportes</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Estado de Publicación -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">📢 Publica tu Empresa</h3>
                    <p class="text-gray-600 text-sm">Haz visible tu empresa para que los clientes puedan encontrarte</p>
                </div>
                <div id="estado-publicacion">
                    <!-- Se llenará dinámicamente -->
                </div>
            </div>

            <!-- Progreso de Perfil -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Completitud del Perfil</span>
                    <span class="text-sm font-bold text-mercarof-cyan" id="porcentaje-perfil">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="barra-progreso" class="bg-gradient-to-r from-mercarof-cyan to-mercarof-cyan-dark h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Lista de verificación -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                <div id="check-info" class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">⭕</span>
                    <span class="text-gray-600">Información básica</span>
                </div>
                <div id="check-fotos" class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">⭕</span>
                    <span class="text-gray-600">Al menos 1 foto</span>
                </div>
                <div id="check-horarios" class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">⭕</span>
                    <span class="text-gray-600">Horarios configurados</span>
                </div>
                <div id="check-servicios" class="flex items-center gap-2 text-sm">
                    <span class="text-gray-400">⭕</span>
                    <span class="text-gray-600">Al menos 1 servicio</span>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex gap-3">
                <button 
                    id="btn-publicar"
                    onclick="togglePublicacion()"
                    class="flex-1 gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    📢 Publicar Servicio Ahora
                </button>
                <a 
                    id="btn-ver-perfil"
                    href="#"
                    target="_blank"
                    class="px-6 py-3 border-2 border-mercarof-cyan text-mercarof-cyan font-semibold rounded-lg hover:bg-mercarof-cyan bg-opacity-5 transition-all hidden"
                >
                    👁️ Ver Perfil Público
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Info de la Empresa -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Información de tu Empresa</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Categoría</p>
                        <p class="font-semibold" id="empresa-categoria">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Ciudad</p>
                        <p class="font-semibold" id="empresa-ciudad">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Teléfono</p>
                        <p class="font-semibold" id="empresa-telefono">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold" id="empresa-email">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dirección</p>
                        <p class="font-semibold" id="empresa-direccion">-</p>
                    </div>
                </div>
            </div>

            <!-- Últimas Reseñas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Últimas Reseñas</h3>
                <div id="ultimas-resenas" class="space-y-4">
                    <div class="text-center py-8 text-gray-500">
                        No hay reseñas aún
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal para subir Banner -->
    <div id="modal-banner" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4" onclick="cerrarModalBanner()">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-900">🖼️ Personalizar Banner</h3>
                <button onclick="cerrarModalBanner()" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
            </div>
            
            <p class="text-gray-600 mb-6">Sube una imagen para personalizar el banner de tu perfil público. Recomendado: 1200x300px</p>
            
            <!-- Vista previa del banner actual -->
            <div id="banner-preview-container" class="mb-6">
                <p class="text-sm font-medium text-gray-700 mb-2">Banner actual:</p>
                <div id="banner-preview" class="h-32 rounded-lg overflow-hidden border-2 border-gray-200 bg-gradient-to-r from-mercarof-navy to-mercarof-cyan flex items-center justify-center">
                    <p class="text-white text-sm">Sin banner (degradado por defecto)</p>
                </div>
            </div>
            
            <!-- Formulario de subida -->
            <form id="form-banner" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Seleccionar imagen
                    </label>
                    <input 
                        type="file" 
                        id="input-banner" 
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent"
                        onchange="previewBanner(event)"
                    >
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF, WEBP. Máximo 5MB</p>
                </div>
                
                <div id="preview-nueva-imagen" class="hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">Vista previa:</p>
                    <img id="preview-banner-img" src="" alt="Preview" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                </div>
                
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="flex-1 gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all"
                    >
                        📤 Subir Banner
                    </button>
                    <button 
                        type="button"
                        onclick="eliminarBanner()"
                        class="px-6 py-3 border-2 border-red-500 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-all"
                    >
                        🗑️ Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = null; // Variable global para el token

        // Verificar autenticación
        window.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('auth_token');
            authToken = token; // Asignar a variable global
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
            let empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const userRole = localStorage.getItem('user_role');

            if (!token || userRole !== 'empresa') {
                window.location.href = '/login';
                return;
            }

            // Recargar datos actuales de la empresa desde el servidor
            if (empresaData.id) {
                try {
                    const response = await fetch(`${API_URL}/empresas/${empresaData.id}`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        // Actualizar localStorage con datos frescos
                        empresaData = result.data;
                        localStorage.setItem('empresa_data', JSON.stringify(empresaData));
                        console.log('✅ Datos de empresa actualizados desde el servidor');
                    }
                } catch (error) {
                    console.error('Error recargando datos de empresa:', error);
                }
            }

            // Configurar logo para redireccionar al dashboard según el rol
            const logoHome = document.getElementById('logo-home');
            if (logoHome) {
                logoHome.addEventListener('click', (e) => {
                    e.preventDefault();
                    const userRole = localStorage.getItem('user_role') || 'cliente';
                    
                    // Redirigir según el rol
                    switch(userRole.toLowerCase()) {
                        case 'admin':
                            window.location.href = '/dashboard/admin';
                            break;
                        case 'empresa':
                            window.location.href = '/dashboard/empresa';
                            break;
                        case 'cliente':
                        default:
                            window.location.href = '/dashboard/cliente';
                            break;
                    }
                });
            }

            // Mostrar nombre de la empresa
            document.getElementById('empresa-name').textContent = empresaData.nombre_comercial || 'Mi Empresa';
            document.getElementById('empresa-descripcion').textContent = empresaData.descripcion || 'Gestiona tu negocio en ServiLocal';

            // Mostrar plan
            if (empresaData.plan) {
                document.getElementById('plan-name').textContent = empresaData.plan.nombre || 'Gratis';
            }

            // Mostrar stats iniciales (se actualizarán después)
            document.getElementById('stat-vistas').textContent = empresaData.total_vistas || 0;
            document.getElementById('stat-clics').textContent = empresaData.total_clics || 0;
            const calificacionInicial = parseFloat(empresaData.calificacion_promedio) || 0;
            document.getElementById('stat-calificacion').textContent = calificacionInicial.toFixed(2);
            document.getElementById('stat-resenas').textContent = empresaData.total_resenas || 0;

            // Mostrar info de empresa
            if (empresaData.categoria) {
                document.getElementById('empresa-categoria').textContent = empresaData.categoria.nombre || '-';
            }
            if (empresaData.ciudad) {
                document.getElementById('empresa-ciudad').textContent = `${empresaData.ciudad.nombre || '-'}, ${empresaData.ciudad.estado || ''}`;
            }
            document.getElementById('empresa-telefono').textContent = empresaData.telefono || '-';
            document.getElementById('empresa-email').textContent = empresaData.email_contacto || '-';
            document.getElementById('empresa-direccion').textContent = empresaData.direccion || '-';

            // Ocultar todas las alertas primero
            document.getElementById('alerta-aprobacion').classList.add('hidden');
            document.getElementById('alerta-verificacion').classList.add('hidden');

            // Debug: mostrar estado de aprobación y verificación
            console.log('Estado empresa:', {
                aprobado: empresaData.aprobado,
                verificado: empresaData.verificado,
                activo: empresaData.activo
            });

            // SOLO mostrar alerta si NO está aprobada
            if (!empresaData.aprobado) {
                console.log('Mostrando alerta de aprobación pendiente');
                document.getElementById('alerta-aprobacion').classList.remove('hidden');
            } else {
                console.log('Empresa aprobada, no mostrar alertas');
            }

            // Calcular progreso del perfil
            await calcularProgreso();

            // Actualizar estado de publicación
            actualizarEstadoPublicacion(empresaData.activo);

            // Cargar stats actualizados en tiempo real
            await cargarStatsActualizados();

            // Cargar preview de métricas
            await cargarPreviewMetricas();

            // Cargar contador de reseñas pendientes
            await cargarResenasPendientes();

            // Cargar notificaciones
            await cargarNotificaciones();

            // Cerrar dropdown al hacer click fuera
            document.addEventListener('click', (e) => {
                const dropdown = document.getElementById('dropdown-notificaciones');
                const button = e.target.closest('[onclick="toggleNotificaciones()"]');
                if (!dropdown.contains(e.target) && !button) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        // Cerrar sesión
        function cerrarSesion() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            localStorage.removeItem('user_role');
            localStorage.removeItem('empresa_data');
            window.location.href = '/login';
        }

        // Cargar stats actualizados desde el servidor
        async function cargarStatsActualizados() {
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            
            if (!empresaData.id) return;

            try {
                // Recargar datos completos de la empresa desde el servidor
                const response = await fetch(`${API_URL}/empresas/${empresaData.id}`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });

                const result = await response.json();
                
                if (result.success) {
                    const empresa = result.data;
                    
                    // Actualizar stats con datos frescos del servidor
                    document.getElementById('stat-vistas').textContent = empresa.total_vistas || 0;
                    document.getElementById('stat-clics').textContent = empresa.total_clics || 0;
                    
                    // Formatear calificación correctamente
                    const calificacion = parseFloat(empresa.calificacion_promedio) || 0;
                    document.getElementById('stat-calificacion').textContent = calificacion.toFixed(2);
                    
                    document.getElementById('stat-resenas').textContent = empresa.total_resenas || 0;
                    
                    // Actualizar localStorage con datos frescos
                    localStorage.setItem('empresa_data', JSON.stringify(empresa));
                    
                    // Verificar plan y mostrar/ocultar secciones
                    verificarAccesoPorPlan(empresa);
                    
                    // Mostrar información de suscripción
                    mostrarInfoSuscripcion(empresa);
                    
                    console.log('✅ Stats actualizados:', {
                        vistas: empresa.total_vistas,
                        clics: empresa.total_clics,
                        calificacion: calificacion.toFixed(2),
                        resenas: empresa.total_resenas
                    });
                }
            } catch (error) {
                console.error('Error cargando stats actualizados:', error);
            }
        }

        // Cargar preview de métricas
        async function cargarPreviewMetricas() {
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            
            if (!empresaData.id) return;

            try {
                const fechaFin = new Date();
                const fechaInicio = new Date();
                fechaInicio.setDate(fechaInicio.getDate() - 30);

                const response = await fetch(
                    `${API_URL}/empresas/${empresaData.id}/metricas?fecha_inicio=${fechaInicio.toISOString().split('T')[0]}&fecha_fin=${fechaFin.toISOString().split('T')[0]}`,
                    { headers: { 'Authorization': `Bearer ${authToken}` } }
                );

                const result = await response.json();
                
                if (result.success) {
                    const vistas = result.data.resumen.periodo.vistas || 0;
                    const clicsTel = result.data.resumen.periodo.clics_telefono || 0;
                    const clicsWA = result.data.resumen.periodo.clics_whatsapp || 0;
                    const clicsWeb = result.data.resumen.periodo.clics_sitio_web || 0;
                    const totalClics = clicsTel + clicsWA + clicsWeb;
                    const conversion = vistas > 0 ? ((totalClics / vistas) * 100).toFixed(1) : 0;

                    document.getElementById('preview-vistas').textContent = vistas;
                    document.getElementById('preview-clics').textContent = totalClics;
                    document.getElementById('preview-conversion').textContent = conversion + '%';
                }
            } catch (error) {
                console.error('Error cargando preview de métricas:', error);
            }
        }

        // Cargar reseñas pendientes de responder
        async function cargarResenasPendientes() {
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            
            if (!empresaData.id) return;

            try {
                const response = await fetch(
                    `${API_URL}/empresas/${empresaData.id}/resenas`,
                    { headers: { 'Authorization': `Bearer ${authToken}` } }
                );

                const result = await response.json();
                
                if (result.success) {
                    const resenas = result.data.data || result.data || [];
                    const pendientes = resenas.filter(r => !r.respuesta_empresa).length;
                    
                    if (pendientes > 0) {
                        // Mostrar badge en stat card
                        const badgeStat = document.getElementById('badge-resenas-pendientes');
                        badgeStat.textContent = pendientes;
                        badgeStat.classList.remove('hidden');
                        badgeStat.classList.add('flex');
                        
                        // Mostrar texto de pendientes
                        const textPendientes = document.getElementById('text-pendientes');
                        textPendientes.textContent = `${pendientes} sin responder`;
                        textPendientes.style.display = 'block';
                        
                        // Mostrar badge en acciones rápidas
                        const badgeQuick = document.getElementById('badge-resenas-quick');
                        badgeQuick.textContent = pendientes;
                        badgeQuick.classList.remove('hidden');
                    }
                }
            } catch (error) {
                console.error('Error cargando reseñas pendientes:', error);
            }
        }

        // Cargar notificaciones
        async function cargarNotificaciones() {
            try {
                const response = await fetch(`${API_URL}/notifications`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });

                const result = await response.json();
                
                if (result.success) {
                    const notificaciones = result.data.notificaciones || [];
                    const noLeidas = result.data.no_leidas || 0;
                    
                    // Actualizar badge
                    const badge = document.getElementById('badge-notificaciones');
                    if (noLeidas > 0) {
                        badge.textContent = noLeidas > 9 ? '9+' : noLeidas;
                        badge.classList.remove('hidden');
                        badge.classList.add('flex');
                    } else {
                        badge.classList.add('hidden');
                        badge.classList.remove('flex');
                    }
                    
                    // Renderizar lista de notificaciones
                    const lista = document.getElementById('lista-notificaciones');
                    if (notificaciones.length === 0) {
                        lista.innerHTML = `
                            <div class="p-8 text-center text-gray-500">
                                <span class="text-4xl mb-2 block">🔔</span>
                                <p>No tienes notificaciones</p>
                            </div>
                        `;
                    } else {
                        lista.innerHTML = notificaciones.map(n => `
                            <div class="p-4 hover:bg-gray-50 transition-colors ${!n.leida ? 'bg-mercarof-cyan bg-opacity-5' : ''}">
                                <div class="flex items-start gap-3">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-sm">${n.titulo}</h4>
                                        <p class="text-sm text-gray-600 mt-1">${n.mensaje}</p>
                                        <p class="text-xs text-gray-400 mt-2">${formatFechaNotificacion(n.created_at)}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        ${!n.leida ? `
                                            <button onclick="marcarLeida(${n.id})" class="text-mercarof-cyan hover:text-mercarof-cyan-dark text-xs font-medium">
                                                ✓
                                            </button>
                                        ` : ''}
                                        <button onclick="eliminarNotificacion(${n.id})" class="text-red-500 hover:text-red-700 text-xs font-medium">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    }
                }
            } catch (error) {
                console.error('Error cargando notificaciones:', error);
            }
        }

        // Toggle dropdown de notificaciones
        function toggleNotificaciones() {
            const dropdown = document.getElementById('dropdown-notificaciones');
            dropdown.classList.toggle('hidden');
        }

        // Marcar notificación como leída
        async function marcarLeida(id) {
            try {
                const response = await fetch(`${API_URL}/notifications/${id}/marcar-leida`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    await cargarNotificaciones();
                }
            } catch (error) {
                console.error('Error marcando notificación:', error);
            }
        }

        // Marcar todas como leídas
        async function marcarTodasLeidas() {
            try {
                const response = await fetch(`${API_URL}/notifications/marcar-todas-leidas`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    await cargarNotificaciones();
                }
            } catch (error) {
                console.error('Error marcando todas leídas:', error);
            }
        }

        // Eliminar notificación
        async function eliminarNotificacion(id) {
            if (!confirm('¿Eliminar esta notificación?')) return;
            
            try {
                const response = await fetch(`${API_URL}/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    }
                });

                if (response.ok) {
                    await cargarNotificaciones();
                }
            } catch (error) {
                console.error('Error eliminando notificación:', error);
            }
        }

        // Mostrar información de suscripción
        function mostrarInfoSuscripcion(empresa) {
            console.log('🔍 mostrarInfoSuscripcion() llamada');
            console.log('📦 Datos de empresa recibidos:', empresa);
            
            // Solo mostrar para planes pagos (Básico o Premium)
            if (!empresa.plan) {
                console.warn('⚠️ No hay información de plan en empresa');
                return;
            }
            
            console.log('📋 Plan detectado:', empresa.plan.nombre, '(slug:', empresa.plan.slug + ')');
            
            if (empresa.plan.slug === 'gratis') {
                console.log('ℹ️ Plan Gratis detectado - No mostrar contador');
                return;
            }

            // Verificar si hay suscripción activa
            if (!empresa.suscripcion_activa) {
                console.warn('⚠️ Empresa tiene plan pago pero NO HAY suscripción activa en los datos');
                console.log('📊 Estructura completa de empresa:', JSON.stringify(empresa, null, 2));
                return;
            }
            
            console.log('✅ Suscripción activa encontrada:', empresa.suscripcion_activa);
            
            const suscripcion = empresa.suscripcion_activa;
            const fechaFin = new Date(suscripcion.fecha_fin);
            const hoy = new Date();
            
            // Calcular días restantes
            const diferencia = fechaFin - hoy;
            const diasRestantes = Math.ceil(diferencia / (1000 * 60 * 60 * 24));
            
            console.log('📅 Información de suscripción:', {
                plan: empresa.plan.nombre,
                diasRestantes,
                fechaFin: fechaFin.toLocaleDateString('es-ES')
            });
            
            if (diasRestantes > 0) {
                const seccionInfo = document.getElementById('suscripcion-info');
                const spanDias = document.getElementById('dias-restantes');
                const spanFecha = document.getElementById('fecha-vencimiento');
                
                if (seccionInfo && spanDias && spanFecha) {
                    // Mostrar días restantes con color según urgencia
                    let colorClase = '';
                    let emoji = '⏰';
                    let mensajeAdicional = '';
                    
                    if (diasRestantes <= 3) {
                        colorClase = 'text-red-300';
                        emoji = '⚠️';
                        mensajeAdicional = '¡Tu plan vence pronto!';
                        mostrarAlertaVencimiento(diasRestantes, fechaFin, 'urgente');
                    } else if (diasRestantes <= 7) {
                        colorClase = 'text-yellow-300';
                        emoji = '⏰';
                        mensajeAdicional = 'Tu plan vence pronto';
                        mostrarAlertaVencimiento(diasRestantes, fechaFin, 'advertencia');
                    } else if (diasRestantes <= 15) {
                        colorClase = 'text-blue-300';
                        emoji = '📅';
                    } else {
                        colorClase = 'text-green-300';
                        emoji = '✅';
                    }
                    
                    spanDias.className = `text-base font-bold ${colorClase}`;
                    spanDias.innerHTML = `${emoji} ${diasRestantes} día${diasRestantes !== 1 ? 's' : ''} restante${diasRestantes !== 1 ? 's' : ''}`;
                    
                    // Formatear fecha de vencimiento
                    const opciones = { day: '2-digit', month: 'long', year: 'numeric' };
                    spanFecha.textContent = fechaFin.toLocaleDateString('es-ES', opciones);
                    
                    seccionInfo.style.display = 'block';
                    
                    console.log('✅ Información de suscripción mostrada:', {
                        diasRestantes,
                        colorClase,
                        emoji
                    });
                }
            } else if (diasRestantes <= 0) {
                console.warn('⚠️ Plan vencido o por vencer hoy');
                mostrarAlertaVencimiento(0, fechaFin, 'vencido');
            }
        }

        // Mostrar alerta de vencimiento en la parte superior del dashboard
        function mostrarAlertaVencimiento(diasRestantes, fechaVencimiento, tipo) {
            // Verificar si ya existe una alerta de vencimiento
            let alertaExistente = document.getElementById('alerta-vencimiento');
            if (alertaExistente) {
                alertaExistente.remove();
            }

            let colorBorde = '';
            let colorFondo = '';
            let emoji = '';
            let titulo = '';
            let mensaje = '';
            let botonTexto = '🔄 Renovar Plan';
            
            if (tipo === 'vencido') {
                colorBorde = 'border-red-400';
                colorFondo = 'bg-red-50';
                emoji = '🚨';
                titulo = '¡Tu plan ha vencido!';
                mensaje = `Tu suscripción venció el ${fechaVencimiento.toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' })}. Renueva ahora para seguir disfrutando de los beneficios.`;
            } else if (tipo === 'urgente') {
                colorBorde = 'border-red-400';
                colorFondo = 'bg-red-50';
                emoji = '⚠️';
                titulo = `¡Tu plan vence en ${diasRestantes} día${diasRestantes !== 1 ? 's' : ''}!`;
                mensaje = `Tu suscripción vence el ${fechaVencimiento.toLocaleDateString('es-ES', { day: '2-digit', month: 'long' })}. Renueva pronto para no perder tus beneficios.`;
            } else if (tipo === 'advertencia') {
                colorBorde = 'border-yellow-400';
                colorFondo = 'bg-yellow-50';
                emoji = '⏰';
                titulo = `Tu plan vence en ${diasRestantes} días`;
                mensaje = `Tu suscripción vence el ${fechaVencimiento.toLocaleDateString('es-ES', { day: '2-digit', month: 'long' })}. Considera renovarla pronto.`;
            }

            const alerta = document.createElement('div');
            alerta.id = 'alerta-vencimiento';
            alerta.className = `${colorFondo} border-l-4 ${colorBorde} p-4 mb-8 rounded-r-lg shadow-md`;
            alerta.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <span class="text-3xl">${emoji}</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-bold ${tipo === 'vencido' || tipo === 'urgente' ? 'text-red-800' : 'text-yellow-800'}">
                                ${titulo}
                            </p>
                            <p class="text-sm ${tipo === 'vencido' || tipo === 'urgente' ? 'text-red-700' : 'text-yellow-700'} mt-1">
                                ${mensaje}
                            </p>
                        </div>
                    </div>
                    <a href="/empresa/solicitar-plan" class="flex-shrink-0 ml-4 px-6 py-2 ${tipo === 'vencido' || tipo === 'urgente' ? 'bg-red-600 hover:bg-red-700' : 'bg-yellow-600 hover:bg-yellow-700'} text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                        ${botonTexto}
                    </a>
                </div>
            `;

            // Insertar después del header gradient
            const mainContent = document.querySelector('.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8.py-8');
            if (mainContent) {
                const headerGradient = mainContent.querySelector('.gradient-bg');
                if (headerGradient) {
                    headerGradient.after(alerta);
                } else {
                    mainContent.insertBefore(alerta, mainContent.firstChild);
                }
            }
        }

        // Verificar acceso por plan
        function verificarAccesoPorPlan(empresa) {
            if (!empresa.plan) return;
            
            const planSlug = empresa.plan.slug;
            const seccionMetricas = document.getElementById('seccion-metricas');
            const ctaMejorarPlan = document.getElementById('cta-mejorar-plan');
            
            // Si es plan gratis, ocultar métricas y mostrar CTA
            if (planSlug === 'gratis') {
                if (seccionMetricas) seccionMetricas.style.display = 'none';
                if (ctaMejorarPlan) ctaMejorarPlan.style.display = 'block';
            } else {
                // Plan básico o premium: mostrar métricas, ocultar CTA
                if (seccionMetricas) seccionMetricas.style.display = 'block';
                if (ctaMejorarPlan) ctaMejorarPlan.style.display = 'none';
            }
            
            // Mostrar badge de boost si tiene plan básico y boost activo
            if (planSlug === 'basico' && empresa.boost_hasta) {
                const boostHasta = new Date(empresa.boost_hasta);
                if (boostHasta > new Date()) {
                    // Tiene boost activo
                    const diasRestantes = Math.ceil((boostHasta - new Date()) / (1000 * 60 * 60 * 24));
                    mostrarBadgeBoost(diasRestantes);
                }
            }
        }

        // Mostrar badge de boost
        function mostrarBadgeBoost(diasRestantes) {
            const planContainer = document.querySelector('.bg-mercarof-cyan.rounded-lg.shadow-md.text-white');
            if (planContainer && !document.getElementById('boost-badge')) {
                const badge = document.createElement('div');
                badge.id = 'boost-badge';
                badge.className = 'mt-2 bg-yellow-400 text-mercarof-navy px-3 py-1 rounded-full text-xs font-bold inline-block';
                badge.innerHTML = `🔥 Boost activo (${diasRestantes} día${diasRestantes !== 1 ? 's' : ''} restante${diasRestantes !== 1 ? 's' : ''})`;
                planContainer.appendChild(badge);
            }
        }

        // Formatear fecha de notificación
        function formatFechaNotificacion(fecha) {
            const date = new Date(fecha);
            const ahora = new Date();
            const diff = ahora - date;
            const minutos = Math.floor(diff / 60000);
            const horas = Math.floor(diff / 3600000);
            const dias = Math.floor(diff / 86400000);
            
            if (minutos < 1) return 'Justo ahora';
            if (minutos < 60) return `Hace ${minutos} minuto${minutos > 1 ? 's' : ''}`;
            if (horas < 24) return `Hace ${horas} hora${horas > 1 ? 's' : ''}`;
            if (dias < 7) return `Hace ${dias} día${dias > 1 ? 's' : ''}`;
            return date.toLocaleDateString('es-MX', { day: '2-digit', month: 'short' });
        }

        // Calcular progreso del perfil
        async function calcularProgreso() {
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            let completados = 0;
            let total = 4;

            // 1. Información básica completa
            if (empresaData.descripcion && empresaData.telefono && empresaData.direccion) {
                completados++;
                document.getElementById('check-info').innerHTML = '<span class="text-green-500">✅</span><span class="text-gray-900 font-medium">Información básica</span>';
            }

            // 2. Verificar fotos
            try {
                const fotosRes = await fetch(`${API_URL}/empresas/${empresaData.id}/fotos`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });
                const fotosData = await fotosRes.json();
                if (fotosData.success && fotosData.data.length > 0) {
                    completados++;
                    document.getElementById('check-fotos').innerHTML = `<span class="text-green-500">✅</span><span class="text-gray-900 font-medium">Al menos 1 foto (${fotosData.data.length})</span>`;
                }
            } catch (error) {
                console.error('Error verificando fotos:', error);
            }

            // 3. Verificar horarios
            try {
                const horariosRes = await fetch(`${API_URL}/empresas/${empresaData.id}/horarios`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });
                const horariosData = await horariosRes.json();
                if (horariosData.success && horariosData.data.length > 0) {
                    completados++;
                    document.getElementById('check-horarios').innerHTML = `<span class="text-green-500">✅</span><span class="text-gray-900 font-medium">Horarios configurados (${horariosData.data.length} días)</span>`;
                }
            } catch (error) {
                console.error('Error verificando horarios:', error);
            }

            // 4. Verificar servicios
            try {
                const serviciosRes = await fetch(`${API_URL}/empresas/${empresaData.id}/servicios`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });
                const serviciosData = await serviciosRes.json();
                if (serviciosData.success && serviciosData.data.length > 0) {
                    completados++;
                    document.getElementById('check-servicios').innerHTML = `<span class="text-green-500">✅</span><span class="text-gray-900 font-medium">Al menos 1 servicio (${serviciosData.data.length})</span>`;
                }
            } catch (error) {
                console.error('Error verificando servicios:', error);
            }

            // Actualizar barra de progreso
            const porcentaje = Math.round((completados / total) * 100);
            document.getElementById('porcentaje-perfil').textContent = porcentaje + '%';
            document.getElementById('barra-progreso').style.width = porcentaje + '%';

            // Habilitar/deshabilitar botón de publicar
            const btnPublicar = document.getElementById('btn-publicar');
            if (completados >= 3) {
                btnPublicar.disabled = false;
            } else {
                btnPublicar.disabled = true;
                btnPublicar.title = 'Completa al menos información básica, fotos y servicios para publicar';
            }

            return porcentaje;
        }

        // Actualizar estado de publicación
        function actualizarEstadoPublicacion(activo) {
            const estadoDiv = document.getElementById('estado-publicacion');
            const btnPublicar = document.getElementById('btn-publicar');
            const btnVerPerfil = document.getElementById('btn-ver-perfil');
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const aprobado = empresaData.aprobado || false;

            // Si la empresa no está aprobada, mostrar estado pendiente de aprobación
            if (!aprobado) {
                estadoDiv.innerHTML = '<span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-semibold">⏳ Pendiente de Aprobación</span>';
                btnPublicar.textContent = '⏳ Esperando Aprobación';
                btnPublicar.disabled = true;
                btnPublicar.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                btnPublicar.classList.remove('gradient-bg', 'bg-red-600', 'hover:bg-red-700');
                btnVerPerfil.classList.add('hidden', 'opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                btnVerPerfil.title = 'Tu empresa debe ser aprobada por un administrador antes de poder ver el perfil público';
                return;
            }

            // Si está aprobada, funcionamiento normal
            btnPublicar.disabled = false;
            btnPublicar.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
            
            if (activo) {
                estadoDiv.innerHTML = '<span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">✅ Publicado</span>';
                btnPublicar.textContent = '🔒 Despublicar';
                btnPublicar.classList.remove('gradient-bg');
                btnPublicar.classList.add('bg-red-600', 'hover:bg-red-700');
                btnVerPerfil.classList.remove('hidden', 'opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                btnVerPerfil.href = `/perfil-empresa/${empresaData.id}`;
                btnVerPerfil.title = 'Ver cómo se ve tu perfil para los clientes';
            } else {
                estadoDiv.innerHTML = '<span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-sm font-semibold">⭕ No publicado</span>';
                btnPublicar.textContent = '📢 Publicar Servicio Ahora';
                btnPublicar.classList.add('gradient-bg');
                btnPublicar.classList.remove('bg-red-600', 'hover:bg-red-700');
                btnVerPerfil.classList.add('hidden');
            }
        }

        // Toggle publicación
        async function togglePublicacion() {
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            
            // Verificar si la empresa está aprobada
            if (!empresaData.aprobado) {
                alert('⏳ Tu empresa debe ser aprobada por un administrador antes de poder publicarla en el marketplace.\n\nPor favor, espera la revisión de tu información.');
                return;
            }
            
            const nuevoEstado = !empresaData.activo;

            if (!nuevoEstado) {
                if (!confirm('¿Estás seguro de despublicar tu empresa? Los clientes no podrán encontrarte.')) {
                    return;
                }
            }

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaData.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: JSON.stringify({ activo: nuevoEstado })
                });

                const result = await response.json();

                if (result.success) {
                    // Actualizar localStorage
                    empresaData.activo = nuevoEstado;
                    localStorage.setItem('empresa_data', JSON.stringify(empresaData));

                    // Actualizar UI
                    actualizarEstadoPublicacion(nuevoEstado);

                    // Mensaje de éxito
                    if (nuevoEstado) {
                        alert('🎉 ¡Tu empresa ha sido publicada! Los clientes ya pueden encontrarte.');
                        // Abrir perfil público
                        window.open(`/perfil-empresa/${empresaData.id}`, '_blank');
                    } else {
                        alert('✅ Tu empresa ha sido despublicada.');
                    }
                } else {
                    alert('❌ Error: ' + (result.message || 'No se pudo actualizar el estado'));
                }
            } catch (error) {
                alert('❌ Error de conexión. Intente nuevamente.');
                console.error('Error:', error);
            }
        }

        // Funciones para el Banner
        function abrirModalBanner() {
            const modal = document.getElementById('modal-banner');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Cargar banner actual si existe
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const previewDiv = document.getElementById('banner-preview');
            
            if (empresaData.banner) {
                previewDiv.innerHTML = `<img src="${empresaData.banner}" alt="Banner actual" class="w-full h-full object-cover">`;
            } else {
                previewDiv.innerHTML = '<p class="text-white text-sm">Sin banner (degradado por defecto)</p>';
            }
        }

        function cerrarModalBanner() {
            const modal = document.getElementById('modal-banner');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('input-banner').value = '';
            document.getElementById('preview-nueva-imagen').classList.add('hidden');
        }

        function previewBanner(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('preview-banner-img');
                    previewImg.src = e.target.result;
                    document.getElementById('preview-nueva-imagen').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Subir banner
        document.getElementById('form-banner').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const fileInput = document.getElementById('input-banner');
            const file = fileInput.files[0];
            
            if (!file) {
                alert('Por favor selecciona una imagen');
                return;
            }

            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const token = localStorage.getItem('auth_token');
            
            if (!empresaData.id || !token) {
                alert('Error: No se encontró información de la empresa');
                return;
            }

            const formData = new FormData();
            formData.append('banner', file);

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaData.id}/banner`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Actualizar localStorage
                    empresaData.banner = result.data.banner;
                    localStorage.setItem('empresa_data', JSON.stringify(empresaData));
                    
                    // Actualizar vista previa
                    const previewDiv = document.getElementById('banner-preview');
                    previewDiv.innerHTML = `<img src="${result.data.banner}" alt="Banner actual" class="w-full h-full object-cover">`;
                    
                    alert('✅ Banner subido exitosamente');
                    cerrarModalBanner();
                    
                    // Recargar página para ver cambios
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert('❌ Error: ' + (result.message || 'No se pudo subir el banner'));
                }
            } catch (error) {
                alert('❌ Error de conexión. Intente nuevamente.');
                console.error('Error:', error);
            }
        });

        // Eliminar banner
        async function eliminarBanner() {
            if (!confirm('¿Estás seguro de que deseas eliminar el banner? Se mostrará el degradado por defecto.')) {
                return;
            }

            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const token = localStorage.getItem('auth_token');
            
            if (!empresaData.id || !token) {
                alert('Error: No se encontró información de la empresa');
                return;
            }

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaData.id}/banner`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                const result = await response.json();

                if (result.success) {
                    // Actualizar localStorage
                    empresaData.banner = null;
                    localStorage.setItem('empresa_data', JSON.stringify(empresaData));
                    
                    // Actualizar vista previa
                    const previewDiv = document.getElementById('banner-preview');
                    previewDiv.innerHTML = '<p class="text-white text-sm">Sin banner (degradado por defecto)</p>';
                    
                    alert('✅ Banner eliminado exitosamente');
                    cerrarModalBanner();
                    
                    // Recargar página
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert('❌ Error: ' + (result.message || 'No se pudo eliminar el banner'));
                }
            } catch (error) {
                alert('❌ Error de conexión. Intente nuevamente.');
                console.error('Error:', error);
            }
        }

        // Cargar badge de órdenes pendientes
        async function cargarBadgeOrdenes() {
            try {
                const response = await fetch(`${API_URL}/empresa/ordenes?estado=todos`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success && result.stats.pagadas > 0) {
                    const badge = document.getElementById('badge-ordenes-pendientes');
                    if (badge) {
                        badge.textContent = result.stats.pagadas;
                        badge.classList.remove('hidden');
                    }
                }
            } catch (error) {
                console.error('Error cargando badge:', error);
            }
        }

        // Inicializar badge al cargar
        setTimeout(() => {
            cargarBadgeOrdenes();
        }, 500);
    </script>

    <!-- Script para validar botón de retroceder - INLINE MEJORADO -->
    <script>
        console.log('🔴 SCRIPT DE RETROCEDER CARGANDO...');(function(){'use strict';console.log('🟢 IIFE EJECUTÁNDOSE...');function isAuthenticated(){const token=localStorage.getItem('auth_token');const userData=localStorage.getItem('user_data');console.log('🔍 Verificando autenticación:',{token:!!token,userData:!!userData});return token!==null&&userData!==null}function getUserName(){const userData=localStorage.getItem('user_data');if(userData){try{const user=JSON.parse(userData);return user.name||'Usuario'}catch(e){return'Usuario'}}return'Usuario'}function getUserRole(){return localStorage.getItem('user_role')||'usuario'}function logout(){console.log('🚪 Cerrando sesión...');localStorage.removeItem('auth_token');localStorage.removeItem('user_data');localStorage.removeItem('user_role');localStorage.removeItem('empresa_data');window.location.href='/login'}function init(){console.log('🚀 INICIANDO BackButtonLogout...');if(!isAuthenticated()){console.log('⚠️ Usuario NO autenticado');return}console.log('✅ Usuario AUTENTICADO');console.log('👤 Usuario:',getUserName());console.log('🎭 Rol:',getUserRole());const modal=document.createElement('div');modal.id='logout-modal';modal.style.cssText='display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;';modal.innerHTML=`<div style="background:white; border-radius:0.5rem; padding:1.5rem; max-width:28rem; width:90%; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);"><div style="display:flex; gap:1rem; margin-bottom:1rem;"><div style="width:3rem; height:3rem; background:#FEF3C7; border-radius:9999px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><span style="font-size:1.5rem;">⚠️</span></div><div style="flex:1;"><h3 style="font-size:1.125rem; font-weight:700; color:#111; margin-bottom:0.25rem;">¿Cerrar sesión?</h3><p style="font-size:0.875rem; color:#6B7280;">Estás intentando salir. ¿Deseas cerrar tu sesión?</p></div></div><div style="background:#DBEAFE; border:1px solid #BFDBFE; border-radius:0.5rem; padding:0.75rem; margin-bottom:1rem;"><p style="font-size:0.875rem; color:#1E40AF;"><strong>Usuario:</strong> <span id="modal-user">${getUserName()}</span></p><p style="font-size:0.875rem; color:#1E3A8A;"><strong>Rol:</strong> <span id="modal-role">${getUserRole()}</span></p></div><div style="display:flex; gap:0.75rem;"><button id="btn-cancel" style="flex:1; background:#E5E7EB; color:#374151; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">No, quedarme</button><button id="btn-logout" style="flex:1; background:#DC2626; color:white; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">Sí, cerrar sesión</button></div></div>`;document.body.appendChild(modal);console.log('✅ Modal creado');console.log('📝 Agregando entradas al historial...');history.pushState({backButtonProtection:true,page:1},'',location.href);history.pushState({backButtonProtection:true,page:2},'',location.href);console.log('📌 Entradas agregadas al historial');console.log('📊 History length:',history.length);let modalVisible=false;console.log('📝 Registrando evento popstate...');window.addEventListener('popstate',function(event){console.log('⬅️ ¡¡¡POPSTATE DETECTADO!!!');console.log('Estado:',event.state);console.log('History length:',history.length);if(!isAuthenticated()){console.log('⚠️ No autenticado, permitiendo navegación');return}console.log('🛑 Mostrando modal...');event.preventDefault();event.stopPropagation();modal.style.display='flex';document.body.style.overflow='hidden';modalVisible=true;history.pushState({backButtonProtection:true,page:Date.now()},'',location.href);console.log('📌 Página mantenida en historial')},true);document.getElementById('btn-cancel').onclick=function(){console.log('✅ Usuario canceló');modal.style.display='none';document.body.style.overflow='';modalVisible=false};document.getElementById('btn-logout').onclick=function(){console.log('🔴 Usuario confirmó logout');logout()};modal.onclick=function(e){if(e.target===modal){console.log('🖱️ Click fuera del modal');modal.style.display='none';document.body.style.overflow='';modalVisible=false}};document.addEventListener('keydown',function(e){if(e.key==='Escape'&&modal.style.display==='flex'){console.log('⌨️ ESC presionado');modal.style.display='none';document.body.style.overflow='';modalVisible=false}});console.log('🎉 BackButtonLogout COMPLETAMENTE INICIALIZADO')}if(document.readyState==='loading'){console.log('⏳ Esperando DOMContentLoaded...');document.addEventListener('DOMContentLoaded',init)}else{console.log('✅ DOM ya cargado, ejecutando inmediatamente');init()}})();console.log('🔵 SCRIPT DE RETROCEDER TERMINÓ DE CARGAR');
    </script>

</body>
</html>

