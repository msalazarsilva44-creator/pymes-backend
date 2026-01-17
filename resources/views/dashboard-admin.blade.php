<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ServiLocal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .main-bg {
            background-color: #f3f4f6;
        }
        
        /* Personalizar Notyf */
        .notyf__toast {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .notyf__toast--success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .notyf__toast--error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        /* Modal Cerrar Sesión */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
        }
        
        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        .modal-icon {
            animation: iconBounce 0.6s ease-out;
        }
        
        @keyframes iconBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .btn-hover-effect {
            transition: all 0.3s ease;
        }
        
        .btn-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <a href="#" id="logo-home" class="text-2xl font-bold text-white cursor-pointer">
                        🛡️ ServiLocal Admin
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-white text-sm" id="admin-name">Admin</span>
                    <button onclick="cerrarSesion()" class="bg-white text-purple-700 hover:bg-gray-100 font-semibold px-4 py-2 rounded-lg transition-all">
                        Cerrar Sesión
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Panel de Administración</h1>
            <p class="text-gray-600">Gestiona todas las empresas, usuarios y contenido de ServiLocal</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-500 text-sm font-medium">Total Empresas</h3>
                    <span class="text-2xl">🏢</span>
                </div>
                <p class="text-3xl font-bold text-gray-900" id="total-empresas">0</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-500 text-sm font-medium">Total Clientes</h3>
                    <span class="text-2xl">👥</span>
                </div>
                <p class="text-3xl font-bold text-gray-900" id="total-clientes">0</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-500 text-sm font-medium">Empresas Activas</h3>
                    <span class="text-2xl">✅</span>
                </div>
                <p class="text-3xl font-bold text-green-600" id="empresas-activas">0</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-500 text-sm font-medium">Empresas Pendientes</h3>
                    <span class="text-2xl">⏳</span>
                </div>
                <p class="text-3xl font-bold text-orange-600" id="empresas-pendientes">0</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-500 text-sm font-medium">Suscripciones</h3>
                    <span class="text-2xl">💳</span>
                </div>
                <p class="text-3xl font-bold text-purple-600" id="suscripciones-pendientes">0</p>
            </div>
        </div>

        <!-- Management Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Empresas Pendientes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">🔍 Empresas Pendientes de Aprobación</h2>
                <p class="text-gray-600 text-sm mb-4">Empresas que necesitan ser aprobadas para aparecer en el marketplace</p>
                <div id="empresas-list" class="space-y-3 mb-4">
                    <!-- Se llenará dinámicamente -->
                </div>
                <a href="/admin/empresas-pendientes" class="block w-full text-center gradient-bg text-white font-semibold py-3 rounded-lg hover:shadow-lg transition-all">
                    Ver Todas las Pendientes →
                </a>
            </div>

            <!-- Gestión Rápida -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">⚡ Gestión Rápida</h2>
                <div class="space-y-3">
                    <a href="/admin/empresas" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">Ver Todas las Empresas</h3>
                                <p class="text-sm text-gray-600">Gestionar empresas registradas</p>
                            </div>
                            <span class="text-2xl">→</span>
                        </div>
                    </a>
                    
                    <a href="/admin/suscripciones-pendientes" class="block p-4 border border-purple-200 rounded-lg hover:bg-purple-50 transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">Aprobar Suscripciones</h3>
                                <p class="text-sm text-gray-600">Revisar pagos de planes Básico/Premium</p>
                            </div>
                            <span class="text-2xl text-purple-600">💳</span>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">Ver Todos los Usuarios</h3>
                                <p class="text-sm text-gray-600">Gestionar clientes registrados</p>
                            </div>
                            <span class="text-2xl">→</span>
                        </div>
                    </a>
                    
                    <a href="/admin/categorias" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">Categorías</h3>
                                <p class="text-sm text-gray-600">Gestionar categorías de servicios</p>
                            </div>
                            <span class="text-2xl">📁</span>
                        </div>
                    </a>
                    
                    <a href="/admin/reportes" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">Dashboard Ejecutivo</h3>
                                <p class="text-sm text-gray-600">Ver estadísticas y reportes completos</p>
                            </div>
                            <span class="text-2xl">📊</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>

    </main>

    <!-- Notyf JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        // Inicializar Notyf
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' },
            dismissible: true,
            ripple: true,
            types: [
                {
                    type: 'info',
                    background: 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)',
                    icon: {
                        className: 'notyf__icon--info',
                        tagName: 'i',
                        text: 'ℹ️'
                    }
                },
                {
                    type: 'warning',
                    background: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                    icon: {
                        className: 'notyf__icon--warning',
                        tagName: 'i',
                        text: '⚠️'
                    }
                }
            ]
        });

        const API_URL = 'http://localhost:8000/api';
        const ADMIN_API_URL = 'http://localhost:8000/admin/api';

        // Verificar autenticación y permisos de admin
        const authToken = localStorage.getItem('auth_token');
        const userRole = localStorage.getItem('user_role');

        // Verificación avanzada de autenticación
        async function verificarAutenticacion() {
            if (!authToken || userRole !== 'admin') {
                console.warn('⚠️ No hay token o no es admin - Redirigiendo...');
                window.location.href = '/login';
                return false;
            }

            try {
                // Verificar que el token sea válido consultando el backend
                const response = await fetch(`${API_URL}/auth/me`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    console.error('❌ Token inválido o expirado');
                    localStorage.clear();
                    window.location.href = '/login';
                    return false;
                }

                const data = await response.json();
                
                // Verificar que el usuario sea realmente admin
                if (!data.data || !data.data.role || data.data.role.name !== 'admin') {
                    console.error('❌ Usuario no tiene permisos de admin');
                    notyf.error('❌ No tienes permisos de administrador');
                    localStorage.clear();
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                    return false;
                }

                console.log('✅ Autenticación verificada correctamente');
                
                // Actualizar datos del usuario
                const userData = data.data;
                localStorage.setItem('user_data', JSON.stringify(userData));
                document.getElementById('admin-name').textContent = userData.name;
                
                return true;
                
            } catch (error) {
                console.error('❌ Error verificando autenticación:', error);
                notyf.error('Error de conexión. Por favor intenta nuevamente.');
                return false;
            }
        }

        // Cargar estadísticas desde el nuevo endpoint unificado
        async function cargarEstadisticas() {
            try {
                const response = await fetch(`${ADMIN_API_URL}/stats`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    if (response.status === 403) {
                        notyf.error('❌ No tienes permisos para acceder a esta sección');
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 2000);
                        return;
                    }
                    throw new Error('Error cargando estadísticas');
                }

                const data = await response.json();
                
                if (data.success) {
                    const stats = data.data;
                    
                    // Actualizar cards de estadísticas
                    document.getElementById('total-empresas').textContent = stats.total_empresas;
                    document.getElementById('total-clientes').textContent = stats.total_clientes;
                    document.getElementById('empresas-activas').textContent = stats.empresas_activas;
                    document.getElementById('empresas-pendientes').textContent = stats.empresas_pendientes;
                    document.getElementById('suscripciones-pendientes').textContent = stats.suscripciones_pendientes || 0;
                    
                    console.log('✅ Estadísticas cargadas:', stats);
                } else {
                    console.error('Error en respuesta:', data);
                }
                
                // Cargar empresas pendientes de aprobación
                await cargarEmpresasPendientes();
                
            } catch (error) {
                console.error('Error cargando estadísticas:', error);
                notyf.error('❌ Error al cargar las estadísticas. Verifica tu conexión.');
            }
        }

        // Cargar empresas pendientes de aprobación
        async function cargarEmpresasPendientes() {
            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/pendientes`);
                const data = await response.json();
                
                if (data.success) {
                    const empresasPendientes = data.data;
                    document.getElementById('empresas-pendientes').textContent = empresasPendientes.length;
                    renderizarEmpresasPendientes(empresasPendientes);
                } else {
                    console.error('Error en respuesta:', data);
                    document.getElementById('empresas-pendientes').textContent = '0';
                }
            } catch (error) {
                console.error('Error cargando empresas pendientes:', error);
                document.getElementById('empresas-pendientes').textContent = '0';
            }
        }

        // Renderizar empresas pendientes (preview - máximo 3)
        function renderizarEmpresasPendientes(empresas) {
            const container = document.getElementById('empresas-list');
            
            if (empresas.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-sm">No hay empresas pendientes de aprobación</p>';
                return;
            }
            
            // Mostrar solo las primeras 3
            const empresasPreview = empresas.slice(0, 3);
            
            container.innerHTML = empresasPreview.map(empresa => `
                <div class="p-3 border border-orange-200 bg-orange-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-900">${empresa.nombre_comercial}</h4>
                            <p class="text-sm text-gray-600">RIF: ${empresa.rfc || 'N/A'}</p>
                        </div>
                        <button onclick="window.location.href='/admin/empresas-pendientes'" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Ver →
                        </button>
                    </div>
                </div>
            `).join('');
            
            if (empresas.length > 3) {
                container.innerHTML += `
                    <p class="text-sm text-gray-600 text-center mt-2">
                        ...y ${empresas.length - 3} más
                    </p>
                `;
            }
        }

        // Ver documento
        function verDocumento(rutaDocumento) {
            if (rutaDocumento) {
                window.open(`/storage/${rutaDocumento}`, '_blank');
            } else {
                alert('No hay documento disponible');
            }
        }

        // Cerrar sesión - Mostrar modal
        function cerrarSesion() {
            document.getElementById('modal-logout').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Cancelar logout
        function cancelarLogout() {
            document.getElementById('modal-logout').classList.add('hidden');
            document.body.style.overflow = '';
        }
        
        // Confirmar logout
        function confirmarLogout() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_role');
            localStorage.removeItem('user_data');
            localStorage.removeItem('empresa_data');
            window.location.href = '/login';
        }
        
        // Cerrar modal al hacer clic fuera
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('modal-logout');
            if (e.target === modal) {
                cancelarLogout();
            }
        });
        
        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modal-logout');
                if (!modal.classList.contains('hidden')) {
                    cancelarLogout();
                }
            }
        });

        // Cargar datos al iniciar
        document.addEventListener('DOMContentLoaded', async () => {
            // Verificar autenticación primero
            const isAuthenticated = await verificarAutenticacion();
            
            if (!isAuthenticated) {
                return; // Ya fue redirigido al login
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

            // Cargar estadísticas después de verificar autenticación
            await cargarEstadisticas();
        });
    </script>

    <!-- Modal Cerrar Sesión -->
    <div id="modal-logout" class="hidden fixed inset-0 z-50 modal-overlay flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden">
            <!-- Gradiente superior -->
            <div class="h-2 bg-gradient-to-r from-purple-600 via-pink-500 to-red-500"></div>
            
            <!-- Contenido -->
            <div class="p-8 text-center">
                <!-- Icono -->
                <div class="modal-icon mb-6">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Título -->
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    ¿Cerrar Sesión?
                </h3>
                
                <!-- Descripción -->
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Estás a punto de cerrar tu sesión de administrador. 
                    <span class="block mt-2 text-sm text-gray-500">¿Deseas continuar?</span>
                </p>
                
                <!-- Botones -->
                <div class="flex gap-3">
                    <button 
                        onclick="cancelarLogout()" 
                        class="btn-hover-effect flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-all"
                    >
                        Cancelar
                    </button>
                    <button 
                        onclick="confirmarLogout()" 
                        class="btn-hover-effect flex-1 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all"
                    >
                        Sí, Cerrar Sesión
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para validar botón de retroceder - INLINE MEJORADO -->
    <script>
        console.log('🔴 SCRIPT DE RETROCEDER CARGANDO...');(function(){'use strict';console.log('🟢 IIFE EJECUTÁNDOSE...');function isAuthenticated(){const token=localStorage.getItem('auth_token');const userData=localStorage.getItem('user_data');console.log('🔍 Verificando autenticación:',{token:!!token,userData:!!userData});return token!==null&&userData!==null}function getUserName(){const userData=localStorage.getItem('user_data');if(userData){try{const user=JSON.parse(userData);return user.name||'Usuario'}catch(e){return'Usuario'}}return'Usuario'}function getUserRole(){return localStorage.getItem('user_role')||'usuario'}function logout(){console.log('🚪 Cerrando sesión...');localStorage.removeItem('auth_token');localStorage.removeItem('user_data');localStorage.removeItem('user_role');localStorage.removeItem('empresa_data');window.location.href='/login'}function init(){console.log('🚀 INICIANDO BackButtonLogout...');if(!isAuthenticated()){console.log('⚠️ Usuario NO autenticado');return}console.log('✅ Usuario AUTENTICADO');console.log('👤 Usuario:',getUserName());console.log('🎭 Rol:',getUserRole());const modal=document.createElement('div');modal.id='logout-modal';modal.style.cssText='display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;';modal.innerHTML=`<div style="background:white; border-radius:0.5rem; padding:1.5rem; max-width:28rem; width:90%; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);"><div style="display:flex; gap:1rem; margin-bottom:1rem;"><div style="width:3rem; height:3rem; background:#FEF3C7; border-radius:9999px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><span style="font-size:1.5rem;">⚠️</span></div><div style="flex:1;"><h3 style="font-size:1.125rem; font-weight:700; color:#111; margin-bottom:0.25rem;">¿Cerrar sesión?</h3><p style="font-size:0.875rem; color:#6B7280;">Estás intentando salir. ¿Deseas cerrar tu sesión?</p></div></div><div style="background:#DBEAFE; border:1px solid #BFDBFE; border-radius:0.5rem; padding:0.75rem; margin-bottom:1rem;"><p style="font-size:0.875rem; color:#1E40AF;"><strong>Usuario:</strong> <span id="modal-user">${getUserName()}</span></p><p style="font-size:0.875rem; color:#1E3A8A;"><strong>Rol:</strong> <span id="modal-role">${getUserRole()}</span></p></div><div style="display:flex; gap:0.75rem;"><button id="btn-cancel" style="flex:1; background:#E5E7EB; color:#374151; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">No, quedarme</button><button id="btn-logout" style="flex:1; background:#DC2626; color:white; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">Sí, cerrar sesión</button></div></div>`;document.body.appendChild(modal);console.log('✅ Modal creado');console.log('📝 Agregando entradas al historial...');history.pushState({backButtonProtection:true,page:1},'',location.href);history.pushState({backButtonProtection:true,page:2},'',location.href);console.log('📌 Entradas agregadas al historial');console.log('📊 History length:',history.length);let modalVisible=false;console.log('📝 Registrando evento popstate...');window.addEventListener('popstate',function(event){console.log('⬅️ ¡¡¡POPSTATE DETECTADO!!!');console.log('Estado:',event.state);console.log('History length:',history.length);if(!isAuthenticated()){console.log('⚠️ No autenticado, permitiendo navegación');return}console.log('🛑 Mostrando modal...');event.preventDefault();event.stopPropagation();modal.style.display='flex';document.body.style.overflow='hidden';modalVisible=true;history.pushState({backButtonProtection:true,page:Date.now()},'',location.href);console.log('📌 Página mantenida en historial')},true);document.getElementById('btn-cancel').onclick=function(){console.log('✅ Usuario canceló');modal.style.display='none';document.body.style.overflow='';modalVisible=false};document.getElementById('btn-logout').onclick=function(){console.log('🔴 Usuario confirmó logout');logout()};modal.onclick=function(e){if(e.target===modal){console.log('🖱️ Click fuera del modal');modal.style.display='none';document.body.style.overflow='';modalVisible=false}};document.addEventListener('keydown',function(e){if(e.key==='Escape'&&modal.style.display==='flex'){console.log('⌨️ ESC presionado');modal.style.display='none';document.body.style.overflow='';modalVisible=false}});console.log('🎉 BackButtonLogout COMPLETAMENTE INICIALIZADO')}if(document.readyState==='loading'){console.log('⏳ Esperando DOMContentLoaded...');document.addEventListener('DOMContentLoaded',init)}else{console.log('✅ DOM ya cargado, ejecutando inmediatamente');init()}})();console.log('🔵 SCRIPT DE RETROCEDER TERMINÓ DE CARGAR');
    </script>

</body>
</html>

