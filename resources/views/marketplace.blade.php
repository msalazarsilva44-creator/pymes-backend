<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - MERCAROF</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%);
        }
        .gradient-hero {
            background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%);
        }
        .gradient-cta {
            background: linear-gradient(135deg, #00A3E0 0%, #0082B8 100%);
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
            height: 40px;
            width: auto;
        }
    </style>
</head>
<body class="main-bg">

    <!-- ==================== HEADER ==================== -->
    <header class="gradient-bg shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="/" class="logo-container">
                    <img src="/logo-mercarof.jpeg" alt="MERCAROF Logo" class="h-10">
                    <span class="text-2xl font-bold text-white">MERCAROF</span>
                </a>

                <!-- Buscador -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <div class="relative w-full">
                        <input 
                            type="text" 
                            id="buscador"
                            placeholder="Buscar servicios, empresas..."
                            class="w-full px-4 py-3 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-mercarof-cyan"
                            onkeyup="filtrarEmpresas()"
                        >
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    <a href="/login" class="hidden sm:inline-block text-white hover:text-gray-200 font-medium px-4 py-2 rounded-lg transition-all">
                        Iniciar Sesión
                    </a>
                    <a href="/registro" class="bg-white text-mercarof-navy hover:bg-gray-100 font-semibold px-6 py-2 rounded-lg transition-all shadow-md">
                        Registrarse
                    </a>
                </div>
            </div>

            <!-- Buscador móvil -->
            <div class="md:hidden pb-4">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        id="buscador-mobile"
                        placeholder="Buscar servicios..."
                        class="w-full px-4 py-2 pl-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-mercarof-cyan"
                        onkeyup="filtrarEmpresas()"
                    >
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    <!-- ==================== NAVEGACIÓN CATEGORÍAS ==================== -->
    <nav class="bg-white shadow-sm sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex overflow-x-auto py-4 gap-3 scrollbar-hide" id="categorias-nav">
                <button onclick="filtrarPorCategoria(null)" class="categoria-btn whitespace-nowrap px-4 py-2 bg-mercarof-cyan text-white rounded-full font-medium hover:bg-mercarof-cyan-dark transition-all text-sm">
                    Todas las Categorías
                </button>
                <!-- Se llenarán dinámicamente -->
            </div>
        </div>
    </nav>

    <!-- ==================== CONTENIDO PRINCIPAL ==================== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Banner de registro -->
        <div class="bg-gradient-to-r from-mercarof-navy to-mercarof-cyan rounded-lg shadow-lg p-4 sm:p-6 mb-8 text-white">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                <div class="flex-1">
                    <h2 class="text-xl sm:text-2xl font-bold mb-2">¿Quieres ver los perfiles completos?</h2>
                    <p class="text-sm sm:text-base text-mercarof-cyan-light">Regístrate gratis y accede a información detallada, contacta empresas y más.</p>
                </div>
                <a href="/registro" class="w-full md:w-auto bg-white text-mercarof-navy hover:bg-gray-100 font-semibold px-8 py-3 rounded-lg transition-all shadow-md text-center">
                    Crear Cuenta Gratis
                </a>
            </div>
        </div>

        <!-- Filtros adicionales -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                <div class="w-full sm:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por:</label>
                    <select id="orden" onchange="ordenarEmpresas()" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        <option value="plan">Plan (Premium primero)</option>
                        <option value="nombre">Nombre (A-Z)</option>
                        <option value="recientes">Más recientes</option>
                    </select>
                </div>
                <div id="contador-resultados" class="text-sm text-gray-600 sm:ml-auto">
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

    <!-- Modal de restricción -->
    <div id="modal-restriccion" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 relative">
            <button onclick="cerrarModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="text-center">
                <div class="text-5xl mb-4">🔒</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Regístrate para ver más</h3>
                <p class="text-gray-600 mb-6">Crea una cuenta gratuita para acceder a los perfiles completos de las empresas, ver sus servicios, horarios y contactarlas directamente.</p>
                <div class="flex gap-3">
                    <button onclick="cerrarModal()" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all">
                        Cancelar
                    </button>
                    <a href="/registro" class="flex-1 gradient-cta text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all text-center">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SCRIPTS ==================== -->
    <script>
        const API_URL = 'http://localhost:8000/api';
        let empresasData = [];
        let categoriaActual = null;

        // Cargar datos iniciales
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
                btn.className = 'categoria-btn whitespace-nowrap px-4 py-2 bg-gray-100 text-gray-700 rounded-full font-medium hover:bg-mercarof-cyan hover:bg-opacity-10 hover:text-mercarof-navy transition-all text-sm';
                btn.innerHTML = cat.nombre; // Sin emoji
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
    // ✅ FIX: No duplicar /storage/
    const logoUrl = empresa.logo || '';
    
    return `
    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all overflow-hidden cursor-pointer transform hover:-translate-y-1 duration-300 relative" onclick="verPerfilEmpresa(${empresa.id})">
        <!-- Badge Premium -->
        ${planSlug === 'premium' ? '<div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white text-xs font-bold px-3 py-1 absolute top-2 right-2 rounded-full shadow-md z-10">⭐ PREMIUM</div>' : ''}
        ${planSlug === 'basico' ? '<div class="bg-blue-500 text-white text-xs font-bold px-3 py-1 absolute top-2 right-2 rounded-full shadow-md z-10">✓ Verificado</div>' : ''}
        
        <!-- Logo/Imagen -->
        <div class="relative h-48 bg-gradient-to-br from-blue-50 to-cyan-50 flex items-center justify-center overflow-hidden">
            ${logoUrl ? 
                `<img src="${logoUrl}" alt="${nombreEmpresa}" class="w-full h-full object-cover" onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<span class=\\'text-6xl\\'>${categoriaIcono}</span>';">` :
                `<span class="text-6xl">${categoriaIcono}</span>`
            }
        </div>
        
        <!-- Contenido -->
        <div class="p-5">
            <h3 class="font-bold text-lg text-gray-900 mb-2 truncate">${nombreEmpresa}</h3>
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
                btn.classList.remove('bg-mercarof-cyan', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            event.target.classList.remove('bg-gray-100', 'text-gray-700');
            event.target.classList.add('bg-mercarof-cyan', 'text-white');

            aplicarFiltros();
        }

        // Filtrar empresas por búsqueda
        function filtrarEmpresas() {
            aplicarFiltros();
        }

        // Aplicar filtros combinados
        function aplicarFiltros() {
            const textoBusqueda = (document.getElementById('buscador').value || document.getElementById('buscador-mobile').value).toLowerCase();
            
            let empresasFiltradas = empresasData;

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

        // Ver perfil de empresa (restringido)
        function verPerfilEmpresa(id) {
            // Mostrar modal de restricción
            const modal = document.getElementById('modal-restriccion');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Cerrar modal
        function cerrarModal() {
            const modal = document.getElementById('modal-restriccion');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Sincronizar buscadores
        document.getElementById('buscador').addEventListener('input', (e) => {
            document.getElementById('buscador-mobile').value = e.target.value;
        });
        document.getElementById('buscador-mobile').addEventListener('input', (e) => {
            document.getElementById('buscador').value = e.target.value;
        });

        // Inicializar
        document.addEventListener('DOMContentLoaded', () => {
            cargarEmpresas();
        });
    </script>

</body>
</html>

