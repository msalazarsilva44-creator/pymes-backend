<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente - MERCAROF</title>
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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="main-bg">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-4">
                    <a href="#" id="logo-home" class="text-2xl font-bold text-mercarof-navy cursor-pointer">MERCAROF</a>
                    <span class="text-sm text-gray-500">/ Dashboard Cliente</span>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Carrito de compras -->
                    <a href="/mis-compras" class="relative p-2 text-gray-600 hover:text-mercarof-cyan transition-colors" title="Mi Carrito">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="cart-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
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
            <p class="text-mercarof-cyan-light">Encuentra los mejores servicios locales en tu ciudad</p>
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
                    <div class="w-12 h-12 bg-mercarof-cyan bg-opacity-10 rounded-lg flex items-center justify-center">
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
                <a href="/buscar" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">🔍</span>
                    <div>
                        <p class="font-semibold text-gray-900">Buscar Servicios</p>
                        <p class="text-sm text-gray-600">Encuentra lo que necesitas</p>
                    </div>
                </a>

                <a href="/categorias" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">📂</span>
                    <div>
                        <p class="font-semibold text-gray-900">Ver Categorías</p>
                        <p class="text-sm text-gray-600">Explora por categoría</p>
                    </div>
                </a>

                <a href="/mis-resenas" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
                    <span class="text-2xl">⭐</span>
                    <div>
                        <p class="font-semibold text-gray-900">Mis Reseñas</p>
                        <p class="text-sm text-gray-600">Ver mis calificaciones</p>
                    </div>
                </a>

                <a href="/perfil" class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg hover:border-mercarof-cyan hover:shadow-md transition-all">
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

    <!-- Modal Servicios -->
    <div id="modal-servicios" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full max-h-[80vh] overflow-hidden shadow-2xl">
            <div class="p-4 border-b bg-gradient-to-r from-mercarof-navy to-mercarof-cyan">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white" id="modal-servicios-titulo">Servicios</h3>
                    <button onclick="cerrarModalServicios()" class="text-white/80 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="modal-servicios-contenido" class="p-4 overflow-y-auto max-h-96">
                <div class="text-center py-8">
                    <div class="animate-spin w-8 h-8 border-4 border-mercarof-cyan border-t-transparent rounded-full mx-auto"></div>
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
            
            // Cargar contador del carrito
            await cargarContadorCarrito();
        });

        // Cargar contador del carrito
        async function cargarContadorCarrito() {
            const token = localStorage.getItem('auth_token');
            if (!token) return;
            
            try {
                const response = await fetch(`${API_URL}/carrito/count`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                
                if (result.success) {
                    const badge = document.getElementById('cart-badge');
                    if (result.count > 0) {
                        badge.textContent = result.count > 99 ? '99+' : result.count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error cargando carrito:', error);
            }
        }

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
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all relative group">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-12 h-12 bg-mercarof-cyan bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl">${empresa.categoria?.icono || '🏢'}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 truncate">${empresa.nombre_comercial}</h4>
                                    <p class="text-sm text-gray-600">${empresa.categoria?.nombre || 'Servicio'}</p>
                                </div>
                                <!-- Botón carrito -->
                                <button onclick="mostrarServiciosEmpresa(${empresa.id}, '${empresa.nombre_comercial.replace(/'/g, "\\'")}', event)" 
                                        class="p-2 bg-mercarof-navy hover:bg-mercarof-navy-dark text-white rounded-lg transition-all hover:scale-105 shadow-sm" 
                                        title="Ver servicios">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">${empresa.descripcion || 'Sin descripción'}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <span class="text-yellow-500">⭐</span>
                                    <span class="text-sm font-semibold">${empresa.calificacion_promedio || '0.0'}</span>
                                    <span class="text-xs text-gray-500">(${empresa.total_resenas || 0})</span>
                                </div>
                                <a href="/perfil-empresa/${empresa.id}" class="text-sm text-mercarof-cyan hover:text-mercarof-cyan-dark font-medium">
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

        // ==================== FUNCIONES DE CARRITO ====================

        // Mostrar servicios de una empresa
        async function mostrarServiciosEmpresa(empresaId, nombreEmpresa, event) {
            event.preventDefault();
            event.stopPropagation();
            
            document.getElementById('modal-servicios-titulo').textContent = nombreEmpresa;
            document.getElementById('modal-servicios').classList.remove('hidden');
            
            const contenido = document.getElementById('modal-servicios-contenido');
            contenido.innerHTML = `
                <div class="text-center py-8">
                    <div class="animate-spin w-8 h-8 border-4 border-mercarof-cyan border-t-transparent rounded-full mx-auto"></div>
                    <p class="text-gray-500 mt-2 text-sm">Cargando servicios...</p>
                </div>
            `;

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}`);
                const result = await response.json();

                if (!result.success || !result.data) {
                    contenido.innerHTML = `<div class="text-center py-8 text-red-500">Error al cargar el catálogo</div>`;
                    return;
                }

                const emp = result.data;
                const servs = emp.servicios && emp.servicios.length > 0;
                const prods = emp.productos && emp.productos.length > 0;

                if (result.success && (servs || prods)) {
                    let html = '';
                    if (servs) {
                        html += '<p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Servicios</p>';
                        html += emp.servicios.map(servicio => `
                        <div class="flex items-center justify-between p-3 border rounded-xl mb-2 hover:border-mercarof-cyan transition-all bg-gray-50">
                            <div class="flex-1 min-w-0 mr-3">
                                <h4 class="font-semibold text-gray-900 text-sm">${servicio.nombre}</h4>
                                ${servicio.descripcion ? `<p class="text-xs text-gray-500 truncate">${servicio.descripcion}</p>` : ''}
                                ${servicio.precio ? `<p class="text-mercarof-cyan font-bold text-sm mt-1">${servicio.precio}</p>` : ''}
                            </div>
                            <button onclick="agregarAlCarrito(${servicio.id})" 
                                    class="p-2 bg-mercarof-navy hover:bg-mercarof-navy-dark text-white rounded-lg transition-all hover:scale-105 flex-shrink-0"
                                    title="Agregar al carrito">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>`).join('');
                    }
                    if (prods) {
                        html += '<p class="text-xs font-semibold text-gray-500 mb-2 mt-4 uppercase tracking-wide">Productos</p>';
                        html += emp.productos.map(p => {
                            const thumb = (p.imagenes && p.imagenes.length)
                                ? `<img src="${p.imagenes[0].url}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0 border border-gray-200 shadow-sm" alt="">`
                                : `<div class="w-14 h-14 rounded-lg bg-emerald-100 flex-shrink-0 flex items-center justify-center text-xl">📦</div>`;
                            return `
                        <div class="flex items-center gap-3 p-3 border rounded-xl mb-2 hover:border-emerald-300 transition-all bg-emerald-50/50">
                            ${thumb}
                            <div class="flex-1 min-w-0 mr-1">
                                <div class="flex items-center gap-2 flex-wrap"><h4 class="font-semibold text-gray-900 text-sm">${p.nombre}</h4>${p.es_basico ? '<span class="text-[10px] bg-gray-200 px-1.5 rounded">Básico</span>' : ''}</div>
                                ${p.descripcion ? `<p class="text-xs text-gray-500 truncate">${p.descripcion}</p>` : ''}
                                <p class="text-mercarof-cyan font-bold text-sm mt-1">$${parseFloat(p.precio).toFixed(2)} · Stock ${p.cantidad}</p>
                            </div>
                            ${p.cantidad > 0 ? `<div class="flex items-center gap-2 flex-shrink-0">
                                <input type="number" min="1" max="${p.cantidad}" value="1" id="dash-qty-${p.id}" class="w-14 px-1 py-1 border rounded text-center text-sm">
                                <button onclick="agregarProductoCarritoDashboard(${p.id})" class="p-2 bg-mercarof-navy hover:bg-mercarof-navy-dark text-white rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></button>
                            </div>` : '<span class="text-xs text-red-500">Agotado</span>'}
                        </div>`;
                        }).join('');
                    }
                    contenido.innerHTML = html;
                } else {
                    contenido.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-4xl mb-3">📋</div>
                            <p class="text-gray-500">No hay servicios ni productos disponibles</p>
                            <a href="/perfil-empresa/${empresaId}" class="text-mercarof-cyan hover:underline text-sm mt-2 inline-block">
                                Ver perfil completo →
                            </a>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                contenido.innerHTML = `<div class="text-center py-8 text-red-500">Error al cargar servicios</div>`;
            }
        }

        function cerrarModalServicios() {
            document.getElementById('modal-servicios').classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modal-servicios').addEventListener('click', function(e) {
            if (e.target === this) cerrarModalServicios();
        });

        async function agregarProductoCarritoDashboard(productoId) {
            const token = localStorage.getItem('auth_token');
            if (!token) { alert('Debes iniciar sesión'); return; }
            const input = document.getElementById('dash-qty-' + productoId);
            let cantidad = input ? parseInt(input.value, 10) : 1;
            if (!cantidad || cantidad < 1) cantidad = 1;
            try {
                const response = await fetch(`${API_URL}/carrito`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ producto_id: productoId, cantidad: cantidad })
                });
                const result = await response.json();
                if (result.success) {
                    const badge = document.getElementById('cart-badge');
                    badge.textContent = result.cart_count > 99 ? '99+' : result.cart_count;
                    badge.classList.remove('hidden');
                    showToast('✅ Producto agregado al carrito', 'success');
                } else {
                    showToast(result.message || 'No se pudo agregar', 'error');
                }
            } catch (e) {
                showToast('Error al agregar', 'error');
            }
        }

        // Agregar al carrito
        async function agregarAlCarrito(servicioId) {
            const token = localStorage.getItem('auth_token');
            
            if (!token) {
                alert('Debes iniciar sesión para agregar servicios al carrito');
                return;
            }

            try {
                const response = await fetch(`${API_URL}/carrito`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ servicio_id: servicioId })
                });

                const result = await response.json();

                if (result.success) {
                    // Actualizar badge del carrito
                    const badge = document.getElementById('cart-badge');
                    badge.textContent = result.cart_count > 99 ? '99+' : result.cart_count;
                    badge.classList.remove('hidden');
                    
                    // Notificación
                    showToast('✅ Servicio agregado al carrito', 'success');
                } else {
                    showToast(result.message || 'No se pudo agregar', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error al agregar al carrito', 'error');
            }
        }

        // Toast de notificación
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
            toast.style.animation = 'fadeIn 0.3s ease-out';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }
    </script>

    <!-- Script para validar botón de retroceder - INLINE MEJORADO -->
    <script>
        console.log('🔴 SCRIPT DE RETROCEDER CARGANDO...');(function(){'use strict';console.log('🟢 IIFE EJECUTÁNDOSE...');function isAuthenticated(){const token=localStorage.getItem('auth_token');const userData=localStorage.getItem('user_data');console.log('🔍 Verificando autenticación:',{token:!!token,userData:!!userData});return token!==null&&userData!==null}function getUserName(){const userData=localStorage.getItem('user_data');if(userData){try{const user=JSON.parse(userData);return user.name||'Usuario'}catch(e){return'Usuario'}}return'Usuario'}function getUserRole(){return localStorage.getItem('user_role')||'usuario'}function logout(){console.log('🚪 Cerrando sesión...');localStorage.removeItem('auth_token');localStorage.removeItem('user_data');localStorage.removeItem('user_role');localStorage.removeItem('empresa_data');window.location.href='/login'}function init(){console.log('🚀 INICIANDO BackButtonLogout...');if(!isAuthenticated()){console.log('⚠️ Usuario NO autenticado');return}console.log('✅ Usuario AUTENTICADO');console.log('👤 Usuario:',getUserName());console.log('🎭 Rol:',getUserRole());const modal=document.createElement('div');modal.id='logout-modal';modal.style.cssText='display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;';modal.innerHTML=`<div style="background:white; border-radius:0.5rem; padding:1.5rem; max-width:28rem; width:90%; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);"><div style="display:flex; gap:1rem; margin-bottom:1rem;"><div style="width:3rem; height:3rem; background:#FEF3C7; border-radius:9999px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><span style="font-size:1.5rem;">⚠️</span></div><div style="flex:1;"><h3 style="font-size:1.125rem; font-weight:700; color:#111; margin-bottom:0.25rem;">¿Cerrar sesión?</h3><p style="font-size:0.875rem; color:#6B7280;">Estás intentando salir. ¿Deseas cerrar tu sesión?</p></div></div><div style="background:#DBEAFE; border:1px solid #BFDBFE; border-radius:0.5rem; padding:0.75rem; margin-bottom:1rem;"><p style="font-size:0.875rem; color:#1E40AF;"><strong>Usuario:</strong> <span id="modal-user">${getUserName()}</span></p><p style="font-size:0.875rem; color:#1E3A8A;"><strong>Rol:</strong> <span id="modal-role">${getUserRole()}</span></p></div><div style="display:flex; gap:0.75rem;"><button id="btn-cancel" style="flex:1; background:#E5E7EB; color:#374151; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">No, quedarme</button><button id="btn-logout" style="flex:1; background:#DC2626; color:white; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">Sí, cerrar sesión</button></div></div>`;document.body.appendChild(modal);console.log('✅ Modal creado');console.log('📝 Agregando entradas al historial...');history.pushState({backButtonProtection:true,page:1},'',location.href);history.pushState({backButtonProtection:true,page:2},'',location.href);console.log('📌 Entradas agregadas al historial');console.log('📊 History length:',history.length);let modalVisible=false;console.log('📝 Registrando evento popstate...');window.addEventListener('popstate',function(event){console.log('⬅️ ¡¡¡POPSTATE DETECTADO!!!');console.log('Estado:',event.state);console.log('History length:',history.length);if(!isAuthenticated()){console.log('⚠️ No autenticado, permitiendo navegación');return}console.log('🛑 Mostrando modal...');event.preventDefault();event.stopPropagation();modal.style.display='flex';document.body.style.overflow='hidden';modalVisible=true;history.pushState({backButtonProtection:true,page:Date.now()},'',location.href);console.log('📌 Página mantenida en historial')},true);document.getElementById('btn-cancel').onclick=function(){console.log('✅ Usuario canceló');modal.style.display='none';document.body.style.overflow='';modalVisible=false};document.getElementById('btn-logout').onclick=function(){console.log('🔴 Usuario confirmó logout');logout()};modal.onclick=function(e){if(e.target===modal){console.log('🖱️ Click fuera del modal');modal.style.display='none';document.body.style.overflow='';modalVisible=false}};document.addEventListener('keydown',function(e){if(e.key==='Escape'&&modal.style.display==='flex'){console.log('⌨️ ESC presionado');modal.style.display='none';document.body.style.overflow='';modalVisible=false}});console.log('🎉 BackButtonLogout COMPLETAMENTE INICIALIZADO')}if(document.readyState==='loading'){console.log('⏳ Esperando DOMContentLoaded...');document.addEventListener('DOMContentLoaded',init)}else{console.log('✅ DOM ya cargado, ejecutando inmediatamente');init()}})();console.log('🔵 SCRIPT DE RETROCEDER TERMINÓ DE CARGAR');
    </script>

</body>
</html>

