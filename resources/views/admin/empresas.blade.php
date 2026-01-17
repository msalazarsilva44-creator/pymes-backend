<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Empresas - Admin ServiLocal</title>
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
        
        /* Tabla responsiva */
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <a href="/dashboard/admin" class="text-white hover:text-gray-200">
                        ← Volver al Dashboard
                    </a>
                    <span class="text-white">|</span>
                    <h1 class="text-2xl font-bold text-white">
                        🏢 Gestión de Empresas
                    </h1>
                </div>
                <button onclick="cerrarSesion()" class="bg-white text-purple-700 hover:bg-gray-100 font-semibold px-4 py-2 rounded-lg transition-all">
                    Cerrar Sesión
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Stats Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-gray-500 text-sm mb-1">Total Empresas</h3>
                <p class="text-2xl font-bold text-gray-900" id="stat-total">0</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-gray-500 text-sm mb-1">Activas</h3>
                <p class="text-2xl font-bold text-green-600" id="stat-activas">0</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-gray-500 text-sm mb-1">Inactivas</h3>
                <p class="text-2xl font-bold text-gray-600" id="stat-inactivas">0</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-gray-500 text-sm mb-1">Penalizadas</h3>
                <p class="text-2xl font-bold text-red-600" id="stat-penalizadas">0</p>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">🔍 Filtros y Búsqueda</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Búsqueda -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input 
                        type="text" 
                        id="search-input"
                        placeholder="Nombre, RIF o email..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                </div>

                <!-- Filtro por Categoría -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select id="filter-categoria" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Todas las categorías</option>
                        <!-- Se llenará dinámicamente -->
                    </select>
                </div>

                <!-- Filtro por Ciudad -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                    <select id="filter-ciudad" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Todas las ciudades</option>
                        <!-- Se llenará dinámicamente -->
                    </select>
                </div>

                <!-- Filtro por Plan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Plan</label>
                    <select id="filter-plan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Todos los planes</option>
                        <!-- Se llenará dinámicamente -->
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Filtro por Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select id="filter-estado" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Todos los estados</option>
                        <option value="activa">Activas</option>
                        <option value="inactiva">Inactivas</option>
                        <option value="penalizada">Penalizadas</option>
                        <option value="pendiente">Pendientes de aprobación</option>
                    </select>
                </div>

                <!-- Ordenar por -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                    <select id="sort-by" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="created_at">Fecha de registro</option>
                        <option value="nombre_comercial">Nombre</option>
                        <option value="calificacion_promedio">Calificación</option>
                        <option value="total_vistas">Vistas</option>
                    </select>
                </div>

                <!-- Botones de acción -->
                <div class="flex items-end gap-2">
                    <button onclick="aplicarFiltros()" class="flex-1 gradient-bg text-white font-semibold px-4 py-2 rounded-lg hover:shadow-lg transition-all">
                        Aplicar Filtros
                    </button>
                    <button onclick="limpiarFiltros()" class="px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all">
                        Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de Empresas -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">
                    📋 Listado de Empresas (<span id="total-empresas">0</span>)
                </h2>
            </div>

            <!-- Loading -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
                <p class="text-gray-600 mt-4">Cargando empresas...</p>
            </div>

            <!-- Tabla -->
            <div id="empresas-table-container" class="hidden overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría/Ciudad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Métricas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="empresas-tbody" class="bg-white divide-y divide-gray-200">
                        <!-- Se llenará dinámicamente -->
                    </tbody>
                </table>
            </div>

            <!-- Sin resultados -->
            <div id="no-results" class="hidden text-center py-12">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron empresas</h3>
                <p class="text-gray-600">Intenta ajustar los filtros de búsqueda</p>
            </div>

            <!-- Paginación -->
            <div id="pagination-container" class="hidden px-6 py-4 border-t border-gray-200">
                <!-- Se llenará dinámicamente -->
            </div>
        </div>

    </main>

    <!-- Modal: Ver Información de Empresa -->
    <div id="modal-info" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full">
                <div class="gradient-bg text-white p-6 rounded-t-lg">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">📋 Información de la Empresa</h2>
                        <button onclick="cerrarModalInfo()" class="text-white hover:text-gray-200 text-2xl">×</button>
                    </div>
                </div>
                <div class="p-6 max-h-[70vh] overflow-y-auto" id="modal-info-content">
                    <!-- Se llenará dinámicamente -->
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end">
                    <button onclick="cerrarModalInfo()" class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Penalizar Empresa -->
    <div id="modal-penalizar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="bg-red-600 text-white p-6 rounded-t-lg">
                    <h3 class="text-xl font-bold">⚠️ Penalizar Empresa</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800 text-sm">
                            <strong>Atención:</strong> Esta acción penalizará a la empresa y la desactivará automáticamente del marketplace.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Motivo de la penalización <span class="text-red-500">*</span>
                        </label>
                        <select id="motivo-penalizacion-select" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 mb-3">
                            <option value="">Selecciona un motivo</option>
                            <option value="Estafa comprobada">Estafa comprobada</option>
                            <option value="No cumplió con el servicio">No cumplió con el servicio</option>
                            <option value="Incumplimiento de normas">Incumplimiento de normas</option>
                            <option value="Documentos falsos">Documentos falsos</option>
                            <option value="Reseñas negativas graves">Reseñas negativas graves</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <textarea 
                            id="motivo-penalizacion" 
                            rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                            placeholder="Describe detalladamente el motivo de la penalización..."
                        ></textarea>
                        <p class="text-xs text-gray-500 mt-1">Este motivo será guardado en el historial de la empresa.</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end gap-3">
                    <button onclick="cerrarModalPenalizar()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button onclick="confirmarPenalizacion()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Confirmar Penalización
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Eliminar Empresa -->
    <div id="modal-eliminar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="bg-red-700 text-white p-6 rounded-t-lg">
                    <h3 class="text-xl font-bold">🗑️ Eliminar Empresa</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4 p-4 bg-red-100 border-2 border-red-300 rounded-lg">
                        <p class="text-red-900 font-bold mb-2">⚠️ ADVERTENCIA</p>
                        <p class="text-red-800 text-sm">
                            Esta es una acción <strong>IRREVERSIBLE</strong>. La empresa será eliminada de forma permanente.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Motivo de eliminación <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="motivo-eliminacion" 
                            rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                            placeholder="Explica por qué se elimina esta empresa..."
                        ></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Escribe "ELIMINAR" para confirmar <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="confirmar-eliminacion" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                            placeholder="Escribe exactamente: ELIMINAR"
                        >
                        <p class="text-xs text-gray-500 mt-1">Debes escribir exactamente "ELIMINAR" en mayúsculas.</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end gap-3">
                    <button onclick="cerrarModalEliminar()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button onclick="confirmarEliminacion()" class="px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800">
                        Eliminar Definitivamente
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                    icon: { className: 'notyf__icon--info', tagName: 'i', text: 'ℹ️' }
                },
                {
                    type: 'warning',
                    background: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                    icon: { className: 'notyf__icon--warning', tagName: 'i', text: '⚠️' }
                }
            ]
        });

        const API_URL = 'http://localhost:8000/api';
        const ADMIN_API_URL = 'http://localhost:8000/admin/api';
        const authToken = localStorage.getItem('auth_token');
        
        let empresaActual = null;
        let paginaActual = 1;
        let filtrosActuales = {};

        // Cargar datos iniciales
        document.addEventListener('DOMContentLoaded', async () => {
            await cargarFiltros();
            await cargarEmpresas();
        });

        // Cargar opciones de filtros
        async function cargarFiltros() {
            try {
                // Cargar categorías
                const catRes = await fetch(`${API_URL}/categorias`);
                const categorias = await catRes.json();
                const selectCat = document.getElementById('filter-categoria');
                if (categorias.success && categorias.data) {
                    categorias.data.forEach(cat => {
                        selectCat.innerHTML += `<option value="${cat.id}">${cat.nombre}</option>`;
                    });
                }

                // Cargar ciudades
                const ciudRes = await fetch(`${API_URL}/ciudades`);
                const ciudades = await ciudRes.json();
                const selectCiu = document.getElementById('filter-ciudad');
                if (ciudades.success && ciudades.data) {
                    ciudades.data.forEach(ciu => {
                        selectCiu.innerHTML += `<option value="${ciu.id}">${ciu.nombre}</option>`;
                    });
                }

                // Cargar planes
                const planRes = await fetch(`${API_URL}/planes`);
                const planes = await planRes.json();
                const selectPlan = document.getElementById('filter-plan');
                if (planes.success && planes.data) {
                    planes.data.forEach(plan => {
                        selectPlan.innerHTML += `<option value="${plan.id}">${plan.nombre}</option>`;
                    });
                }
            } catch (error) {
                console.error('Error cargando filtros:', error);
            }
        }

        // Cargar empresas con filtros y paginación
        async function cargarEmpresas(pagina = 1) {
            try {
                document.getElementById('loading').classList.remove('hidden');
                document.getElementById('empresas-table-container').classList.add('hidden');
                document.getElementById('no-results').classList.add('hidden');

                const params = new URLSearchParams({
                    page: pagina,
                    per_page: 20,
                    ...filtrosActuales
                });

                const response = await fetch(`${ADMIN_API_URL}/empresas/lista?${params}`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Error al cargar empresas');

                const data = await response.json();
                
                if (data.success && data.data) {
                    const empresas = data.data.data; // Laravel paginate structure
                    paginaActual = data.data.current_page;
                    
                    if (empresas.length === 0) {
                        document.getElementById('no-results').classList.remove('hidden');
                    } else {
                        renderizarEmpresas(empresas);
                        renderizarPaginacion(data.data);
                        document.getElementById('empresas-table-container').classList.remove('hidden');
                    }

                    actualizarStats(data.data);
                }

                document.getElementById('loading').classList.add('hidden');
                
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('loading').classList.add('hidden');
                notyf.error('❌ Error al cargar las empresas');
            }
        }

        // Renderizar empresas en la tabla
        function renderizarEmpresas(empresas) {
            const tbody = document.getElementById('empresas-tbody');
            tbody.innerHTML = '';

            empresas.forEach(empresa => {
                const estadoBadge = getEstadoBadge(empresa);
                const planBadge = getPlanBadge(empresa);
                const suscripcionInfo = empresa.suscripcion_activa ? '💳 Plan Pago' : '';

                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">${empresa.nombre_comercial}</div>
                            </div>
                            <div class="text-sm text-gray-500">${empresa.rfc || 'Sin RIF'}</div>
                            ${suscripcionInfo ? `<div class="text-xs text-green-600 font-semibold mt-1">${suscripcionInfo}</div>` : ''}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${empresa.categoria?.nombre || 'N/A'}</div>
                            <div class="text-sm text-gray-500">${empresa.ciudad?.nombre || 'N/A'}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${planBadge}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${estadoBadge}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>⭐ ${empresa.calificacion_promedio || 0} (${empresa.total_resenas || 0})</div>
                            <div>👁️ ${empresa.total_vistas || 0} vistas</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex flex-col gap-2">
                                <button onclick="verInfo(${empresa.id})" class="text-blue-600 hover:text-blue-900 font-medium">
                                    🔍 Ver Info
                                </button>
                                ${!empresa.penalizada ? `
                                    <button onclick="toggleEstado(${empresa.id}, ${empresa.activo})" class="text-${empresa.activo ? 'gray' : 'green'}-600 hover:text-${empresa.activo ? 'gray' : 'green'}-900 font-medium">
                                        ${empresa.activo ? '⏸️ Desactivar' : '▶️ Activar'}
                                    </button>
                                    <button onclick="abrirModalPenalizar(${empresa.id})" class="text-orange-600 hover:text-orange-900 font-medium">
                                        ⚠️ Penalizar
                                    </button>
                                ` : `
                                    <button onclick="quitarPenalizacion(${empresa.id})" class="text-green-600 hover:text-green-900 font-medium">
                                        ✅ Quitar Penalización
                                    </button>
                                `}
                                <button onclick="abrirModalEliminar(${empresa.id})" class="text-red-600 hover:text-red-900 font-medium">
                                    🗑️ Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }

        // Obtener badge de estado
        function getEstadoBadge(empresa) {
            if (empresa.penalizada) {
                return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">🚫 Penalizada</span>';
            }
            if (!empresa.aprobado) {
                return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Pendiente</span>';
            }
            if (empresa.activo) {
                return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✅ Activa</span>';
            }
            return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">⏸️ Inactiva</span>';
        }

        // Obtener badge de plan
        function getPlanBadge(empresa) {
            if (!empresa.plan) return '<span class="text-sm text-gray-500">Sin plan</span>';
            const colors = {
                'gratis': 'bg-gray-100 text-gray-800',
                'basico': 'bg-blue-100 text-blue-800',
                'premium': 'bg-purple-100 text-purple-800'
            };
            const color = colors[empresa.plan.slug] || 'bg-gray-100 text-gray-800';
            return `<span class="px-2 py-1 text-xs font-semibold rounded-full ${color}">${empresa.plan.nombre}</span>`;
        }

        // Actualizar estadísticas
        function actualizarStats(data) {
            document.getElementById('stat-total').textContent = data.total || 0;
            document.getElementById('total-empresas').textContent = data.total || 0;
            
            // Calcular stats de los datos actuales (aproximado)
            const empresas = data.data || [];
            const activas = empresas.filter(e => e.activo && !e.penalizada).length;
            const inactivas = empresas.filter(e => !e.activo && !e.penalizada).length;
            const penalizadas = empresas.filter(e => e.penalizada).length;
            
            document.getElementById('stat-activas').textContent = activas;
            document.getElementById('stat-inactivas').textContent = inactivas;
            document.getElementById('stat-penalizadas').textContent = penalizadas;
        }

        // Renderizar paginación
        function renderizarPaginacion(paginacion) {
            const container = document.getElementById('pagination-container');
            if (paginacion.last_page <= 1) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');
            let html = '<div class="flex items-center justify-between">';
            html += `<div class="text-sm text-gray-700">Mostrando ${paginacion.from} a ${paginacion.to} de ${paginacion.total} empresas</div>`;
            html += '<div class="flex gap-2">';

            // Botón anterior
            if (paginacion.current_page > 1) {
                html += `<button onclick="cargarEmpresas(${paginacion.current_page - 1})" class="px-3 py-1 border rounded hover:bg-gray-100">← Anterior</button>`;
            }

            // Páginas
            for (let i = 1; i <= paginacion.last_page; i++) {
                if (i === paginacion.current_page) {
                    html += `<button class="px-3 py-1 bg-purple-600 text-white rounded">${i}</button>`;
                } else if (Math.abs(i - paginacion.current_page) <= 2) {
                    html += `<button onclick="cargarEmpresas(${i})" class="px-3 py-1 border rounded hover:bg-gray-100">${i}</button>`;
                } else if (i === 1 || i === paginacion.last_page) {
                    html += `<button onclick="cargarEmpresas(${i})" class="px-3 py-1 border rounded hover:bg-gray-100">${i}</button>`;
                }
            }

            // Botón siguiente
            if (paginacion.current_page < paginacion.last_page) {
                html += `<button onclick="cargarEmpresas(${paginacion.current_page + 1})" class="px-3 py-1 border rounded hover:bg-gray-100">Siguiente →</button>`;
            }

            html += '</div></div>';
            container.innerHTML = html;
        }

        // Aplicar filtros
        function aplicarFiltros() {
            filtrosActuales = {};
            
            const search = document.getElementById('search-input').value;
            if (search) filtrosActuales.search = search;
            
            const categoria = document.getElementById('filter-categoria').value;
            if (categoria) filtrosActuales.categoria_id = categoria;
            
            const ciudad = document.getElementById('filter-ciudad').value;
            if (ciudad) filtrosActuales.ciudad_id = ciudad;
            
            const plan = document.getElementById('filter-plan').value;
            if (plan) filtrosActuales.plan_id = plan;
            
            const estado = document.getElementById('filter-estado').value;
            if (estado) filtrosActuales.estado = estado;
            
            const sortBy = document.getElementById('sort-by').value;
            if (sortBy) {
                filtrosActuales.sort_by = sortBy;
                filtrosActuales.sort_order = 'desc';
            }

            cargarEmpresas(1);
        }

        // Limpiar filtros
        function limpiarFiltros() {
            document.getElementById('search-input').value = '';
            document.getElementById('filter-categoria').value = '';
            document.getElementById('filter-ciudad').value = '';
            document.getElementById('filter-plan').value = '';
            document.getElementById('filter-estado').value = '';
            document.getElementById('sort-by').value = 'created_at';
            filtrosActuales = {};
            cargarEmpresas(1);
        }

        // Ver información de empresa
        async function verInfo(id) {
            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Error al cargar empresa');

                const data = await response.json();
                if (data.success) {
                    mostrarModalInfo(data.data);
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error al cargar la información');
            }
        }

        // Mostrar modal de información
        function mostrarModalInfo(empresa) {
            const content = document.getElementById('modal-info-content');
            const suscripcion = empresa.suscripcion_activa;
            
            content.innerHTML = `
                <div class="space-y-6">
                    <div>
                        <h4 class="font-bold text-lg mb-2">📋 Información Básica</h4>
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                            <div><span class="text-gray-600">Nombre:</span> <strong>${empresa.nombre_comercial}</strong></div>
                            <div><span class="text-gray-600">RIF:</span> <strong>${empresa.rfc || 'N/A'}</strong></div>
                            <div><span class="text-gray-600">Categoría:</span> <strong>${empresa.categoria?.nombre || 'N/A'}</strong></div>
                            <div><span class="text-gray-600">Ciudad:</span> <strong>${empresa.ciudad?.nombre || 'N/A'}</strong></div>
                            <div><span class="text-gray-600">Plan:</span> <strong>${empresa.plan?.nombre || 'N/A'}</strong></div>
                            <div><span class="text-gray-600">Estado:</span> ${getEstadoBadge(empresa)}</div>
                        </div>
                    </div>

                    ${suscripcion ? `
                    <div>
                        <h4 class="font-bold text-lg mb-2">💳 Suscripción Activa</h4>
                        <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div><span class="text-gray-600">Plan:</span> <strong>${empresa.plan?.nombre}</strong></div>
                                <div><span class="text-gray-600">Precio:</span> <strong>$${empresa.plan?.precio_mensual}/mes</strong></div>
                                <div><span class="text-gray-600">Inicio:</span> <strong>${new Date(suscripcion.fecha_inicio).toLocaleDateString()}</strong></div>
                                <div><span class="text-gray-600">Fin:</span> <strong>${new Date(suscripcion.fecha_fin).toLocaleDateString()}</strong></div>
                                <div><span class="text-gray-600">Estado:</span> <strong class="text-green-600">${suscripcion.estado}</strong></div>
                            </div>
                        </div>
                    </div>
                    ` : '<div class="bg-gray-50 p-4 rounded-lg text-center text-gray-600">Esta empresa no tiene suscripción paga activa</div>'}

                    ${empresa.penalizada ? `
                    <div>
                        <h4 class="font-bold text-lg mb-2 text-red-600">⚠️ Empresa Penalizada</h4>
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                            <div><strong>Motivo:</strong> ${empresa.motivo_penalizacion}</div>
                            <div class="text-sm text-gray-600 mt-2">Penalizada el: ${new Date(empresa.penalizada_at).toLocaleString()}</div>
                        </div>
                    </div>
                    ` : ''}

                    <div>
                        <h4 class="font-bold text-lg mb-2">📊 Métricas</h4>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">${empresa.total_vistas || 0}</div>
                                <div class="text-sm text-gray-600">Vistas</div>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-purple-600">${empresa.total_clics || 0}</div>
                                <div class="text-sm text-gray-600">Clics</div>
                            </div>
                            <div class="bg-yellow-50 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-yellow-600">⭐ ${empresa.calificacion_promedio || 0}</div>
                                <div class="text-sm text-gray-600">${empresa.total_resenas || 0} reseñas</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-lg mb-2">📞 Contacto</h4>
                        <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                            <div><span class="text-gray-600">Email:</span> <strong>${empresa.email_contacto || 'N/A'}</strong></div>
                            <div><span class="text-gray-600">Teléfono:</span> <strong>${empresa.telefono || 'N/A'}</strong></div>
                            <div><span class="text-gray-600">WhatsApp:</span> <strong>${empresa.whatsapp || 'N/A'}</strong></div>
                            <div><span class="text-gray-600">Dirección:</span> <strong>${empresa.direccion || 'N/A'}</strong></div>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('modal-info').classList.remove('hidden');
        }

        function cerrarModalInfo() {
            document.getElementById('modal-info').classList.add('hidden');
        }

        // Toggle estado de empresa
        async function toggleEstado(id, estadoActual) {
            const accion = estadoActual ? 'desactivar' : 'activar';
            if (!confirm(`¿Estás seguro de ${accion} esta empresa?`)) return;

            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${id}/toggle-estado`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                if (!response.ok) throw new Error('Error al cambiar estado');

                const data = await response.json();
                if (data.success) {
                    notyf.success(data.message);
                    await cargarEmpresas(paginaActual);
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error al cambiar el estado');
            }
        }

        // Penalizar empresa
        function abrirModalPenalizar(id) {
            empresaActual = id;
            document.getElementById('motivo-penalizacion').value = '';
            document.getElementById('motivo-penalizacion-select').value = '';
            document.getElementById('modal-penalizar').classList.remove('hidden');
        }

        // Auto-completar motivo al seleccionar opción
        document.getElementById('motivo-penalizacion-select')?.addEventListener('change', function() {
            if (this.value && this.value !== 'Otro') {
                document.getElementById('motivo-penalizacion').value = this.value + ': ';
            }
        });

        async function confirmarPenalizacion() {
            const motivo = document.getElementById('motivo-penalizacion').value.trim();
            if (!motivo) {
                notyf.warning('⚠️ Debes especificar un motivo');
                return;
            }

            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${empresaActual}/penalizar`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ motivo })
                });

                if (!response.ok) throw new Error('Error al penalizar');

                const data = await response.json();
                if (data.success) {
                    notyf.error('Empresa penalizada y desactivada del marketplace');
                    cerrarModalPenalizar();
                    await cargarEmpresas(paginaActual);
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error al penalizar la empresa');
            }
        }

        function cerrarModalPenalizar() {
            document.getElementById('modal-penalizar').classList.add('hidden');
            empresaActual = null;
        }

        // Quitar penalización
        async function quitarPenalizacion(id) {
            if (!confirm('¿Estás seguro de quitar la penalización a esta empresa?')) return;

            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${id}/quitar-penalizacion`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                if (!response.ok) throw new Error('Error');

                const data = await response.json();
                if (data.success) {
                    notyf.success('✅ Penalización removida exitosamente');
                    await cargarEmpresas(paginaActual);
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error al quitar penalización');
            }
        }

        // Eliminar empresa
        function abrirModalEliminar(id) {
            empresaActual = id;
            document.getElementById('motivo-eliminacion').value = '';
            document.getElementById('confirmar-eliminacion').value = '';
            document.getElementById('modal-eliminar').classList.remove('hidden');
        }

        async function confirmarEliminacion() {
            const motivo = document.getElementById('motivo-eliminacion').value.trim();
            const confirmacion = document.getElementById('confirmar-eliminacion').value.trim();

            if (!motivo) {
                notyf.warning('⚠️ Debes especificar un motivo');
                return;
            }

            if (confirmacion !== 'ELIMINAR') {
                notyf.warning('⚠️ Debes escribir exactamente "ELIMINAR"');
                return;
            }

            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${empresaActual}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ motivo, confirmacion })
                });

                if (!response.ok) throw new Error('Error al eliminar');

                const data = await response.json();
                if (data.success) {
                    notyf.success('✅ ' + data.message);
                    cerrarModalEliminar();
                    await cargarEmpresas(paginaActual);
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error al eliminar la empresa');
            }
        }

        function cerrarModalEliminar() {
            document.getElementById('modal-eliminar').classList.add('hidden');
            empresaActual = null;
        }

        // Cerrar sesión
        function cerrarSesion() {
            if (confirm('¿Estás seguro de cerrar sesión?')) {
                localStorage.clear();
                window.location.href = '/login';
            }
        }
    </script>

</body>
</html>

