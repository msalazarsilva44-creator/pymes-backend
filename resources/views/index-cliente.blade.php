<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MERCAROF - Encuentra los mejores servicios</title>
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
        
        /* Modal Cerrar Sesión */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            transition: opacity 0.3s ease;
        }
        
        .modal-content {
            animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.8) translateY(-40px) rotate(-2deg);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0) rotate(0);
            }
        }
        
        .modal-icon-container {
            animation: iconPulse 2s infinite;
        }
        
        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .btn-hover-scale {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .btn-hover-scale:hover {
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .btn-hover-scale:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header Principal -->
    <header class="bg-white shadow-md border-b-2 border-mercarof-cyan border-opacity-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Bar -->
            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                <a href="#" id="logo-home" class="text-2xl font-bold text-mercarof-navy cursor-pointer">
                    MERCAROF
                </a>
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-gray-700">¡Hola, <strong id="user-name" class="text-mercarof-navy">Cliente</strong>!</span>
                    <button onclick="cerrarSesion()" class="text-gray-600 hover:text-red-600 font-medium transition-colors">
                        Salir
                    </button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="py-4">
                <div class="flex gap-3">
                    <input 
                        type="text" 
                        id="search-input"
                        placeholder="Buscar servicios, empresas..." 
                        onkeyup="filtrarEmpresas()"
                        class="flex-1 px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-mercarof-cyan focus:outline-none shadow-sm"
                    >
                    <button class="gradient-bg text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition-all">
                        🔍 Buscar
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-3">
                <!-- Links de navegación - Ocultos en móvil -->
                <div class="hidden md:flex items-center gap-6">
                    <button onclick="filtrarPorCategoria(null)" class="text-gray-700 hover:text-mercarof-cyan font-medium">
                        Todas las Categorías
                    </button>
                    <a href="/ofertas" class="text-gray-700 hover:text-mercarof-cyan font-medium">
                        🔥 Ofertas
                    </a>
                    <a href="/ayuda" class="text-gray-700 hover:text-mercarof-cyan font-medium">
                        ❓ Ayuda
                    </a>
                </div>

                <!-- Texto simplificado en móvil -->
                <div class="md:hidden">
                    <span class="text-gray-700 font-medium text-sm">Inicio</span>
                </div>

                <!-- Iconos de usuario - Simplificados en móvil -->
                <div class="flex items-center gap-3 md:gap-6">
                    <a href="/perfil" class="flex items-center gap-2 text-gray-700 hover:text-mercarof-cyan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium hidden sm:inline">Mi Perfil</span>
                    </a>
                    <a href="/mis-compras" class="flex items-center gap-2 text-gray-700 hover:text-mercarof-cyan relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="cart-badge" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                        <span class="font-medium hidden sm:inline">Mis Compras</span>
                    </a>
                    <a href="/favoritos" class="flex items-center gap-2 text-gray-700 hover:text-mercarof-cyan relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="font-medium hidden sm:inline">Favoritos</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Navegación de Categorías -->
    <nav class="bg-white shadow-sm border-b sticky top-[64px] z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex overflow-x-auto py-4 gap-3 scrollbar-hide" id="categorias-nav">
                <button onclick="filtrarPorCategoria(null)" class="categoria-btn whitespace-nowrap px-4 py-2 bg-mercarof-navy text-white rounded-full font-medium hover:bg-mercarof-navy-dark transition-all text-sm">
                    Todas
                </button>
                <!-- Se llenarán dinámicamente -->
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Banner de Bienvenida -->
        <div class="gradient-bg rounded-xl p-4 sm:p-6 text-white mb-8 shadow-lg">
            <h1 class="text-2xl sm:text-3xl font-bold mb-2">¡Encuentra el servicio perfecto! 🎯</h1>
            <p class="text-sm sm:text-base text-mercarof-cyan-light">Miles de empresas verificadas listas para ayudarte</p>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Estado:</label>
                    <select id="filtro-estado" onchange="filtrarPorEstado()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        <option value="">Todos los estados</option>
                        <!-- Se llenará dinámicamente con los estados disponibles -->
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por:</label>
                    <select id="orden" onchange="ordenarEmpresas()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        <option value="plan">Plan (Premium primero)</option>
                        <option value="nombre">Nombre (A-Z)</option>
                        <option value="recientes">Más recientes</option>
                    </select>
                </div>
                <div id="contador-resultados" class="ml-auto text-sm text-gray-600">
                    <!-- Se llenará dinámicamente -->
                </div>
            </div>
        </div>

        <!-- Grid de Empresas -->
        <div id="empresas-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Se llenarán dinámicamente -->
        </div>

        <!-- Mensaje sin resultados -->
        <div id="sin-resultados" class="hidden text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron resultados</h3>
            <p class="text-gray-600">Intenta con otra búsqueda o categoría</p>
        </div>

        <!-- Loading -->
        <div id="loading" class="text-center py-16">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-mercarof-cyan"></div>
            <p class="text-gray-600 mt-4">Cargando empresas...</p>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">MERCAROF</h3>
                    <p class="text-gray-400 text-sm">Conectando negocios locales con clientes</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Para Clientes</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/ayuda" class="hover:text-white">Ayuda</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Para Empresas</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/registro" class="hover:text-white">Registrar Empresa</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Términos y Condiciones</a></li>
                        <li><a href="#" class="hover:text-white">Política de Privacidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                © 2024 MERCAROF. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let empresasData = [];
        let categoriaActual = null;
        let authToken = '';

        // Verificar autenticación
        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');

            if (!authToken) {
                window.location.href = '/login';
                return;
            }

            // Mostrar nombre del usuario
            document.getElementById('user-name').textContent = userData.name || 'Cliente';
            
            // Cargar contador del carrito
            cargarContadorCarrito();

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

            // Cargar datos
            cargarEmpresas();
        });

        // Cargar empresas
        async function cargarEmpresas() {
            try {
                // Cargar categorías
                const catResponse = await fetch(`${API_URL}/categorias`);
                const catData = await catResponse.json();
                if (catData.success) {
                    renderizarCategorias(catData.data);
                }

                // Cargar empresas activas
                const empResponse = await fetch(`${API_URL}/empresas`);
                const empData = await empResponse.json();
                
                if (empData.success) {
                    // Filtrar solo empresas activas
                    empresasData = empData.data.filter(empresa => empresa.activo === 1 || empresa.activo === true);
                    renderizarEmpresas(empresasData);
                    llenarFiltroEstados(empresasData);
                    document.getElementById('loading').classList.add('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('loading').innerHTML = `
                    <div class="text-center">
                        <p class="text-red-600">❌ Error al cargar las empresas</p>
                        <button onclick="cargarEmpresas()" class="mt-4 text-mercarof-cyan hover:underline">Reintentar</button>
                    </div>
                `;
            }
        }

        // Renderizar categorías
        function renderizarCategorias(categorias) {
            const nav = document.getElementById('categorias-nav');
            categorias.forEach(cat => {
                const btn = document.createElement('button');
                btn.onclick = () => filtrarPorCategoria(cat.id);
                btn.className = 'categoria-btn whitespace-nowrap px-4 py-2 bg-gray-100 text-gray-700 rounded-full font-medium hover:bg-mercarof-cyan hover:bg-opacity-10 hover:text-mercarof-cyan transition-all text-sm';
                btn.innerHTML = cat.nombre;
                nav.appendChild(btn);
            });
        }

        // Renderizar empresas
        function renderizarEmpresas(empresas) {
            const grid = document.getElementById('empresas-grid');
            const sinResultados = document.getElementById('sin-resultados');
            const contador = document.getElementById('contador-resultados');
            
            contador.textContent = `${empresas.length} empresa${empresas.length !== 1 ? 's' : ''} encontrada${empresas.length !== 1 ? 's' : ''}`;

            if (empresas.length === 0) {
                grid.innerHTML = '';
                sinResultados.classList.remove('hidden');
                return;
            }

            sinResultados.classList.add('hidden');
            grid.innerHTML = empresas.map(empresa => {
                const nombreEmpresa = empresa.nombre_comercial || empresa.nombre || 'Sin nombre';
                const planSlug = empresa.plan?.slug || empresa.plan || 'gratis';
                const categoriaIcono = empresa.categoria?.icono || '🏢';
                const categoriaNombre = empresa.categoria?.nombre || 'Sin categoría';
                const ciudadNombre = empresa.ciudad?.nombre || 'Sin ciudad';
                const logoUrl = empresa.logo || ''; // El logo ya viene con el path completo
                
                return `
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all overflow-hidden cursor-pointer transform hover:-translate-y-1 duration-300 relative" onclick="verPerfilEmpresa(${empresa.id})">
                    <!-- Badge Premium -->
                    ${planSlug === 'premium' ? '<div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white text-xs font-bold px-3 py-1 absolute top-2 right-2 rounded-full shadow-md z-10">⭐ PREMIUM</div>' : ''}
                    ${planSlug === 'basico' ? '<div class="bg-blue-500 text-white text-xs font-bold px-3 py-1 absolute top-2 right-2 rounded-full shadow-md z-10">✓ Verificado</div>' : ''}
                    
                    <!-- Logo/Imagen -->
                    <div class="relative h-48 bg-gradient-to-br from-mercarof-cyan from-opacity-10 to-mercarof-navy to-opacity-10 flex items-center justify-center">
                        ${logoUrl ? 
                            `<img src="${logoUrl}" alt="${nombreEmpresa}" class="w-full h-full object-cover">` :
                            `<span class="text-6xl">${categoriaIcono}</span>`
                        }
                    </div>
                    
                    <!-- Contenido -->
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="font-bold text-lg text-gray-900 truncate flex-1">${nombreEmpresa}</h3>
                            <!-- Botón Carrito -->
                            <button onclick="mostrarServiciosEmpresa(${empresa.id}, '${nombreEmpresa.replace(/'/g, "\\'")}', event)" 
                                    class="p-2 bg-mercarof-navy hover:bg-mercarof-navy-dark text-white rounded-lg transition-all hover:scale-110 shadow-sm flex-shrink-0" 
                                    title="Ver servicios y agregar al carrito">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-mercarof-cyan font-medium mb-2">${categoriaNombre}</p>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">${empresa.descripcion || 'Sin descripción disponible'}</p>
                        
                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <span class="text-sm text-gray-500">📍 ${ciudadNombre}</span>
                            <span class="text-mercarof-cyan font-semibold text-sm">Ver más →</span>
                        </div>
                    </div>
                </div>
                `;
            }).join('');
        }

        // Filtrar por categoría
        function filtrarPorCategoria(categoriaId) {
            categoriaActual = categoriaId;
            
            // Actualizar botones
            document.querySelectorAll('.categoria-btn').forEach(btn => {
                btn.classList.remove('bg-mercarof-navy', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            event.target.classList.remove('bg-gray-100', 'text-gray-700');
            event.target.classList.add('bg-mercarof-navy', 'text-white');

            aplicarFiltros();
        }

        // Filtrar empresas por búsqueda
        function filtrarEmpresas() {
            aplicarFiltros();
        }

        // Aplicar filtros combinados
        function aplicarFiltros() {
            const textoBusqueda = (document.getElementById('search-input').value || '').toLowerCase();
            const estadoSeleccionado = document.getElementById('filtro-estado').value;
            
            let empresasFiltradas = empresasData;

            // Filtrar por estado
            if (estadoSeleccionado) {
                empresasFiltradas = empresasFiltradas.filter(e => 
                    e.ciudad?.estado === estadoSeleccionado
                );
            }

            // Filtrar por categoría
            if (categoriaActual) {
                empresasFiltradas = empresasFiltradas.filter(e => e.categoria_id === categoriaActual);
            }

            // Filtrar por texto de búsqueda
            if (textoBusqueda) {
                empresasFiltradas = empresasFiltradas.filter(e => {
                    const nombre = e.nombre_comercial || e.nombre || '';
                    return nombre.toLowerCase().includes(textoBusqueda) ||
                        (e.descripcion && e.descripcion.toLowerCase().includes(textoBusqueda)) ||
                        (e.categoria?.nombre && e.categoria.nombre.toLowerCase().includes(textoBusqueda));
                });
            }

            renderizarEmpresas(empresasFiltradas);
        }

        // Llenar filtro de estados con los estados disponibles
        function llenarFiltroEstados(empresas) {
            const selectEstado = document.getElementById('filtro-estado');
            const estados = new Set();
            
            empresas.forEach(empresa => {
                if (empresa.ciudad?.estado) {
                    estados.add(empresa.ciudad.estado);
                }
            });
            
            // Ordenar estados alfabéticamente
            const estadosOrdenados = Array.from(estados).sort();
            
            // Agregar opciones al select
            estadosOrdenados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado;
                option.textContent = estado;
                selectEstado.appendChild(option);
            });
        }

        // Filtrar empresas por estado
        function filtrarPorEstado() {
            const estadoSeleccionado = document.getElementById('filtro-estado').value;
            let empresasFiltradas = [...empresasData];

            // Aplicar filtro de estado si se seleccionó uno
            if (estadoSeleccionado) {
                empresasFiltradas = empresasFiltradas.filter(e => 
                    e.ciudad?.estado === estadoSeleccionado
                );
            }

            // Aplicar filtro de categoría si hay una activa
            if (categoriaActual) {
                empresasFiltradas = empresasFiltradas.filter(e => e.categoria_id === categoriaActual);
            }

            // Aplicar filtro de búsqueda si hay texto
            const textoBusqueda = document.getElementById('buscador')?.value.toLowerCase();
            if (textoBusqueda) {
                empresasFiltradas = empresasFiltradas.filter(e => {
                    const nombre = e.nombre_comercial || e.nombre || '';
                    return nombre.toLowerCase().includes(textoBusqueda) ||
                        (e.descripcion && e.descripcion.toLowerCase().includes(textoBusqueda)) ||
                        (e.categoria?.nombre && e.categoria.nombre.toLowerCase().includes(textoBusqueda));
                });
            }

            renderizarEmpresas(empresasFiltradas);
            
            // Aplicar ordenamiento actual
            ordenarEmpresas();
        }

        // Ordenar empresas
        function ordenarEmpresas() {
            const orden = document.getElementById('orden').value;
            let empresasOrdenadas = [...empresasData];

            switch(orden) {
                case 'plan':
                    empresasOrdenadas.sort((a, b) => {
                        const planA = a.plan?.slug || a.plan || 'gratis';
                        const planB = b.plan?.slug || b.plan || 'gratis';
                        const planes = { premium: 3, basico: 2, gratis: 1 };
                        return (planes[planB] || 0) - (planes[planA] || 0);
                    });
                    break;
                case 'nombre':
                    empresasOrdenadas.sort((a, b) => {
                        const nombreA = a.nombre_comercial || a.nombre || '';
                        const nombreB = b.nombre_comercial || b.nombre || '';
                        return nombreA.localeCompare(nombreB);
                    });
                    break;
                case 'recientes':
                    empresasOrdenadas.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    break;
            }

            empresasData = empresasOrdenadas;
            aplicarFiltros();
        }

        // Ver perfil de empresa
        function verPerfilEmpresa(id) {
            window.location.href = `/perfil-empresa/${id}`;
        }

        // Cerrar sesión - Mostrar modal
        function cerrarSesion() {
            const modal = document.getElementById('modal-logout');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        
        // Cancelar logout
        function cancelarLogout() {
            const modal = document.getElementById('modal-logout');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        
        // Confirmar logout
        function confirmarLogout() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            localStorage.removeItem('user_role');
            localStorage.removeItem('empresa_data');
            
            // Efecto de salida
            const modal = document.getElementById('modal-logout');
            modal.style.opacity = '0';
            
            setTimeout(() => {
                window.location.href = '/login';
            }, 300);
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
    </script>

    <!-- Modal Cerrar Sesión -->
    <div id="modal-logout" class="hidden fixed inset-0 z-[9999] modal-overlay items-center justify-center p-4">
        <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden">
            <!-- Gradiente superior animado -->
            <div class="h-3 bg-gradient-to-r from-mercarof-navy to-mercarof-cyan"></div>
            
            <!-- Contenido -->
            <div class="p-8 text-center">
                <!-- Icono con animación -->
                <div class="modal-icon-container mb-6">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-mercarof-navy to-mercarof-cyan rounded-full flex items-center justify-center shadow-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Título -->
                <h3 class="text-3xl font-bold text-gray-900 mb-3">
                    ¿Cerrar Sesión?
                </h3>
                
                <!-- Descripción -->
                <p class="text-gray-600 mb-2 leading-relaxed text-lg">
                    Estás a punto de cerrar tu sesión.
                </p>
                <p class="text-sm text-gray-500 mb-8">
                    Tendrás que iniciar sesión nuevamente para acceder.
                </p>
                
                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button 
                        onclick="cancelarLogout()" 
                        class="btn-hover-scale flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-xl transition-all border-2 border-gray-200"
                    >
                        ← Cancelar
                    </button>
                    <button 
                        onclick="confirmarLogout()" 
                        class="btn-hover-scale flex-1 bg-gradient-to-r from-mercarof-navy to-mercarof-cyan hover:from-mercarof-navy-dark hover:to-mercarof-cyan-dark text-white font-bold py-4 px-6 rounded-xl shadow-xl transition-all"
                    >
                        Sí, Cerrar Sesión →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Servicios para Carrito -->
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
        // ==================== FUNCIONES DE CARRITO ====================

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
                
                if (result.success && result.count > 0) {
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                        badge.textContent = result.count > 99 ? '99+' : result.count;
                        badge.classList.remove('hidden');
                    }
                }
            } catch (error) {
                console.error('Error cargando carrito:', error);
            }
        }

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

                if (servs || prods) {
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
                            <button onclick="agregarAlCarritoDesdeModal(${servicio.id}, event)" 
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
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-semibold text-gray-900 text-sm">${p.nombre}</h4>
                                    ${p.es_basico ? '<span class="text-[10px] bg-gray-200 px-1.5 rounded">Básico</span>' : ''}
                                </div>
                                ${p.descripcion ? `<p class="text-xs text-gray-500 truncate">${p.descripcion}</p>` : ''}
                                <p class="text-mercarof-cyan font-bold text-sm mt-1">$${parseFloat(p.precio).toFixed(2)} · Stock ${p.cantidad}</p>
                            </div>
                            ${p.cantidad > 0 ? `
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <input type="number" min="1" max="${p.cantidad}" value="1" id="modal-qty-${p.id}" class="w-14 px-1 py-1 border rounded text-center text-sm">
                                <button onclick="agregarProductoAlCarritoModal(${p.id}, event)" class="p-2 bg-mercarof-navy hover:bg-mercarof-navy-dark text-white rounded-lg transition-all" title="Agregar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
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
                            <button onclick="verPerfilEmpresa(${empresaId}); cerrarModalServicios();" class="text-mercarof-cyan hover:underline text-sm mt-2 inline-block">
                                Ver perfil completo →
                            </button>
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

        // Agregar al carrito desde el modal
        async function agregarAlCarritoDesdeModal(servicioId, event) {
            event.preventDefault();
            event.stopPropagation();
            
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
                    // Actualizar badge del carrito si existe
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                        badge.textContent = result.cart_count > 99 ? '99+' : result.cart_count;
                        badge.classList.remove('hidden');
                    }
                    
                    showToastCarrito('✅ Servicio agregado al carrito', 'success');
                } else {
                    showToastCarrito(result.message || 'No se pudo agregar', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToastCarrito('Error al agregar al carrito', 'error');
            }
        }

        async function agregarProductoAlCarritoModal(productoId, event) {
            event.preventDefault();
            event.stopPropagation();
            const token = localStorage.getItem('auth_token');
            if (!token) {
                alert('Debes iniciar sesión para agregar productos al carrito');
                return;
            }
            const input = document.getElementById('modal-qty-' + productoId);
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
                    if (badge) {
                        badge.textContent = result.cart_count > 99 ? '99+' : result.cart_count;
                        badge.classList.remove('hidden');
                    }
                    showToastCarrito('✅ Producto agregado al carrito', 'success');
                } else {
                    showToastCarrito(result.message || 'No se pudo agregar', 'error');
                }
            } catch (error) {
                showToastCarrito('Error al agregar al carrito', 'error');
            }
        }

        // Toast de notificación para carrito
        function showToastCarrito(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-[60]`;
            toast.style.animation = 'fadeInUp 0.3s ease-out';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }
    </script>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <!-- Script para validar botón de retroceder - INLINE MEJORADO -->
    <script>
        console.log('🔴 SCRIPT DE RETROCEDER CARGANDO...');(function(){'use strict';console.log('🟢 IIFE EJECUTÁNDOSE...');function isAuthenticated(){const token=localStorage.getItem('auth_token');const userData=localStorage.getItem('user_data');console.log('🔍 Verificando autenticación:',{token:!!token,userData:!!userData});return token!==null&&userData!==null}function getUserName(){const userData=localStorage.getItem('user_data');if(userData){try{const user=JSON.parse(userData);return user.name||'Usuario'}catch(e){return'Usuario'}}return'Usuario'}function getUserRole(){return localStorage.getItem('user_role')||'usuario'}function logout(){console.log('🚪 Cerrando sesión...');localStorage.removeItem('auth_token');localStorage.removeItem('user_data');localStorage.removeItem('user_role');localStorage.removeItem('empresa_data');window.location.href='/login'}function init(){console.log('🚀 INICIANDO BackButtonLogout...');if(!isAuthenticated()){console.log('⚠️ Usuario NO autenticado');return}console.log('✅ Usuario AUTENTICADO');console.log('👤 Usuario:',getUserName());console.log('🎭 Rol:',getUserRole());const modal=document.createElement('div');modal.id='logout-modal';modal.style.cssText='display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;';modal.innerHTML=`<div style="background:white; border-radius:0.5rem; padding:1.5rem; max-width:28rem; width:90%; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);"><div style="display:flex; gap:1rem; margin-bottom:1rem;"><div style="width:3rem; height:3rem; background:#FEF3C7; border-radius:9999px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><span style="font-size:1.5rem;">⚠️</span></div><div style="flex:1;"><h3 style="font-size:1.125rem; font-weight:700; color:#111; margin-bottom:0.25rem;">¿Cerrar sesión?</h3><p style="font-size:0.875rem; color:#6B7280;">Estás intentando salir. ¿Deseas cerrar tu sesión?</p></div></div><div style="background:#DBEAFE; border:1px solid #BFDBFE; border-radius:0.5rem; padding:0.75rem; margin-bottom:1rem;"><p style="font-size:0.875rem; color:#1E40AF;"><strong>Usuario:</strong> <span id="modal-user">${getUserName()}</span></p><p style="font-size:0.875rem; color:#1E3A8A;"><strong>Rol:</strong> <span id="modal-role">${getUserRole()}</span></p></div><div style="display:flex; gap:0.75rem;"><button id="btn-cancel" style="flex:1; background:#E5E7EB; color:#374151; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">No, quedarme</button><button id="btn-logout" style="flex:1; background:#DC2626; color:white; font-weight:600; padding:0.75rem 1.5rem; border-radius:0.5rem; border:none; cursor:pointer;">Sí, cerrar sesión</button></div></div>`;document.body.appendChild(modal);console.log('✅ Modal creado');console.log('📝 Agregando entradas al historial...');history.pushState({backButtonProtection:true,page:1},'',location.href);history.pushState({backButtonProtection:true,page:2},'',location.href);console.log('📌 Entradas agregadas al historial');console.log('📊 History length:',history.length);let modalVisible=false;console.log('📝 Registrando evento popstate...');window.addEventListener('popstate',function(event){console.log('⬅️ ¡¡¡POPSTATE DETECTADO!!!');console.log('Estado:',event.state);console.log('History length:',history.length);if(!isAuthenticated()){console.log('⚠️ No autenticado, permitiendo navegación');return}console.log('🛑 Mostrando modal...');event.preventDefault();event.stopPropagation();modal.style.display='flex';document.body.style.overflow='hidden';modalVisible=true;history.pushState({backButtonProtection:true,page:Date.now()},'',location.href);console.log('📌 Página mantenida en historial')},true);document.getElementById('btn-cancel').onclick=function(){console.log('✅ Usuario canceló');modal.style.display='none';document.body.style.overflow='';modalVisible=false};document.getElementById('btn-logout').onclick=function(){console.log('🔴 Usuario confirmó logout');logout()};modal.onclick=function(e){if(e.target===modal){console.log('🖱️ Click fuera del modal');modal.style.display='none';document.body.style.overflow='';modalVisible=false}};document.addEventListener('keydown',function(e){if(e.key==='Escape'&&modal.style.display==='flex'){console.log('⌨️ ESC presionado');modal.style.display='none';document.body.style.overflow='';modalVisible=false}});console.log('🎉 BackButtonLogout COMPLETAMENTE INICIALIZADO')}if(document.readyState==='loading'){console.log('⏳ Esperando DOMContentLoaded...');document.addEventListener('DOMContentLoaded',init)}else{console.log('✅ DOM ya cargado, ejecutando inmediatamente');init()}})();console.log('🔵 SCRIPT DE RETROCEDER TERMINÓ DE CARGAR');
    </script>

</body>
</html>
