<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente - ServiLocal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .main-bg {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="main-bg">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-4">
                    <a href="#" id="logo-home" class="text-2xl font-bold gradient-bg bg-clip-text text-transparent cursor-pointer">ServiLocal</a>
                    <span class="text-sm text-gray-500">/ Dashboard Cliente</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600" id="user-name"></span>
                    <button onclick="cerrarSesion()" class="text-sm text-red-600 hover:text-red-700 font-medium">
                        Cerrar Sesión
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Bienvenida -->
        <div class="gradient-bg rounded-lg p-6 text-white mb-8">
            <h2 class="text-3xl font-bold mb-2">¡Bienvenido de vuelta! 👋</h2>
            <p class="text-purple-100">Encuentra los mejores servicios locales en tu ciudad</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Búsquedas</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Reseñas Escritas</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">❤️</span>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Favoritos</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Acciones Rápidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="/buscar" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:shadow-md transition-all">
                    <span class="text-2xl">🔍</span>
                    <div>
                        <p class="font-semibold text-gray-900">Buscar Servicios</p>
                        <p class="text-sm text-gray-600">Encuentra lo que necesitas</p>
                    </div>
                </a>

                <a href="/categorias" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:shadow-md transition-all">
                    <span class="text-2xl">📂</span>
                    <div>
                        <p class="font-semibold text-gray-900">Ver Categorías</p>
                        <p class="text-sm text-gray-600">Explora por categoría</p>
                    </div>
                </a>

                <a href="/mis-resenas" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:shadow-md transition-all">
                    <span class="text-2xl">⭐</span>
                    <div>
                        <p class="font-semibold text-gray-900">Mis Reseñas</p>
                        <p class="text-sm text-gray-600">Ver mis calificaciones</p>
                    </div>
                </a>

                <a href="/perfil" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:shadow-md transition-all">
                    <span class="text-2xl">👤</span>
                    <div>
                        <p class="font-semibold text-gray-900">Mi Perfil</p>
                        <p class="text-sm text-gray-600">Editar información</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Empresas Destacadas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Empresas Destacadas 🔥</h3>
            <div id="empresas-destacadas" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Se llenarán dinámicamente -->
                <div class="text-center py-8 text-gray-500">
                    Cargando empresas...
                </div>
            </div>
        </div>

    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';

        // Verificar autenticación
        window.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('auth_token');
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
            const userRole = localStorage.getItem('user_role');

            if (!token || userRole !== 'cliente') {
                window.location.href = '/login';
                return;
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

            // Mostrar nombre del usuario
            document.getElementById('user-name').textContent = userData.name || 'Cliente';

            // Cargar empresas destacadas
            await cargarEmpresas();
        });

        // Cerrar sesión
        function cerrarSesion() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            localStorage.removeItem('user_role');
            localStorage.removeItem('empresa_data');
            window.location.href = '/login';
        }

        // Cargar empresas destacadas
        async function cargarEmpresas() {
            try {
                const response = await fetch(`${API_URL}/empresas?limit=6`);
                const result = await response.json();

                const container = document.getElementById('empresas-destacadas');
                
                if (result.success && result.data.data && result.data.data.length > 0) {
                    container.innerHTML = result.data.data.map(empresa => `
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl">${empresa.categoria?.icono || '🏢'}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 truncate">${empresa.nombre_comercial}</h4>
                                    <p class="text-sm text-gray-600">${empresa.categoria?.nombre || 'Servicio'}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">${empresa.descripcion || 'Sin descripción'}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <span class="text-yellow-500">⭐</span>
                                    <span class="text-sm font-semibold">${empresa.calificacion_promedio || '0.0'}</span>
                                    <span class="text-xs text-gray-500">(${empresa.total_resenas || 0})</span>
                                </div>
                                <a href="/empresa/${empresa.id}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                                    Ver más →
                                </a>
                            </div>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No hay empresas disponibles</div>';
                }
            } catch (error) {
                console.error('Error cargando empresas:', error);
                document.getElementById('empresas-destacadas').innerHTML = '<div class="col-span-full text-center py-8 text-red-500">Error cargando empresas</div>';
            }
        }
    </script>

    <!-- Script para validar botón de retroceder - INLINE MEJORADO -->
    <script>
        console.log('🔴 SCRIPT DE RETROCEDER CARGANDO...');(function(){'use strict';console.log('🟢 IIFE EJECUTÁNDOSE...');function isAuthenticated(){const token=localStorage.getItem('auth_token');const userData=localStorage.getItem('user_data');console.log('🔍 Verificando autenticación:',{token:!!token,userData:!!userData});return token!==null&&userData!==null}function getUserName(){const userData=localStorage.getItem('user_data');if(userData){try{const user=JSON.parse(userData);return user.name||'Usuario'}catch(e){return'Usuario'}}return'Usuario'}function getUserRole(){return localStorage.getItem('user_role')||'usuario'}function logout(){console.log('🚪 Cerrando sesión...');localStorage.removeItem('auth_token');localStorage.removeItem('user_data');localStorage.removeItem('user_role');localStorage.removeItem('empresa_data');window.location.href='/login'}function init(){console.log('🚀 INICIANDO BackButtonLogout...');if(!isAuthenticated()){console.log('⚠️ Usuario NO autenticado');return}console.log('✅ Usuario AUTENTICADO');console.log('👤 Usuario:',getUserName());console.log('🎭 Rol:',getUserRole());const modal=document.createElement('div');modal.id='logout-modal';modal.style.cssText='display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;';modal.innerHTML=`<div style="background:white; border-radius:0.5rem; padding:1.5rem; max-width:28rem; width:90%; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);"><div style="display:flex; gap:1rem; margin-bottom:1rem;"><div style="width:3rem; height:3rem; background:#FEF3C7; border-radius:9999px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><span style="font-size:1.5rem;">⚠️</span></div><div style="flex:1;"><h3 style="font-size:1.125rem; font-weight:700; color:#111; margin-bottom:0.25rem;">¿Cerrar sesión?</h3><p style="font-size:0.875rem; color:#6B7280;">Estás intentando salir. ¿Deseas cerrar tu sesión?</p></div></div><div style="background:#DBEAFE; border:1px solid #BFDBFE; border-radius:0.5rem; padding:0.75rem; margin-bottom:1rem;"><p style="font-size:0.875rem; color:#1E40AF;"><strong>Usuario:</strong> <span id="modal-user">${getUserName()}</span></p><p style="font-size:0.875rem; color:#1E3A8A;"><strong>Rol:</strong> <span id="modal-role">${getUserRole()}</span></p></div><div style="display:flex; gap:0.75rem;"><button id="btn-cancel" style="flex:1; background:#E5E7EB; color:#374151; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">No, quedarme</button><button id="btn-logout" style="flex:1; background:#DC2626; color:white; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">Sí, cerrar sesión</button></div></div>`;document.body.appendChild(modal);console.log('✅ Modal creado');console.log('📝 Agregando entradas al historial...');history.pushState({backButtonProtection:true,page:1},'',location.href);history.pushState({backButtonProtection:true,page:2},'',location.href);console.log('📌 Entradas agregadas al historial');console.log('📊 History length:',history.length);let modalVisible=false;console.log('📝 Registrando evento popstate...');window.addEventListener('popstate',function(event){console.log('⬅️ ¡¡¡POPSTATE DETECTADO!!!');console.log('Estado:',event.state);console.log('History length:',history.length);if(!isAuthenticated()){console.log('⚠️ No autenticado, permitiendo navegación');return}console.log('🛑 Mostrando modal...');event.preventDefault();event.stopPropagation();modal.style.display='flex';document.body.style.overflow='hidden';modalVisible=true;history.pushState({backButtonProtection:true,page:Date.now()},'',location.href);console.log('📌 Página mantenida en historial')},true);document.getElementById('btn-cancel').onclick=function(){console.log('✅ Usuario canceló');modal.style.display='none';document.body.style.overflow='';modalVisible=false};document.getElementById('btn-logout').onclick=function(){console.log('🔴 Usuario confirmó logout');logout()};modal.onclick=function(e){if(e.target===modal){console.log('🖱️ Click fuera del modal');modal.style.display='none';document.body.style.overflow='';modalVisible=false}};document.addEventListener('keydown',function(e){if(e.key==='Escape'&&modal.style.display==='flex'){console.log('⌨️ ESC presionado');modal.style.display='none';document.body.style.overflow='';modalVisible=false}});console.log('🎉 BackButtonLogout COMPLETAMENTE INICIALIZADO')}if(document.readyState==='loading'){console.log('⏳ Esperando DOMContentLoaded...');document.addEventListener('DOMContentLoaded',init)}else{console.log('✅ DOM ya cargado, ejecutando inmediatamente');init()}})();console.log('🔵 SCRIPT DE RETROCEDER TERMINÓ DE CARGAR');
    </script>

</body>
</html>

