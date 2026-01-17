<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Categorías - Admin ServiLocal</title>
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
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <a href="/dashboard/admin" class="text-white hover:text-gray-200">
                        ← Volver
                    </a>
                    <span class="text-white">|</span>
                    <h1 class="text-2xl font-bold text-white">
                        📁 Gestión de Categorías
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

        <!-- Stats y Acciones -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-500 text-sm font-medium">Total Categorías</h3>
                    <span class="text-2xl">📁</span>
                </div>
                <p class="text-3xl font-bold text-gray-900" id="total-categorias">0</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-500 text-sm font-medium">Categorías Activas</h3>
                    <span class="text-2xl">✅</span>
                </div>
                <p class="text-3xl font-bold text-green-600" id="categorias-activas">0</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-center">
                <button 
                    onclick="mostrarModalCrear()" 
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg transition-all flex items-center justify-center gap-2"
                >
                    <span class="text-xl">+</span>
                    Nueva Categoría
                </button>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar</label>
                    <input 
                        type="text" 
                        id="search"
                        placeholder="Nombre o descripción..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
                    <select 
                        id="filter-estado"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >
                        <option value="">Todas</option>
                        <option value="1">Activas</option>
                        <option value="0">Inactivas</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button 
                        onclick="aplicarFiltros()" 
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-lg transition-all"
                    >
                        Aplicar Filtros
                    </button>
                    <button 
                        onclick="limpiarFiltros()" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-lg transition-all"
                    >
                        Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de Categorías -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Empresas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody id="categorias-tbody" class="bg-white divide-y divide-gray-200">
                        <!-- Se llenará dinámicamente -->
                    </tbody>
                </table>
            </div>

            <!-- Loading -->
            <div id="loading" class="text-center py-16">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
                <p class="text-gray-600 mt-4">Cargando categorías...</p>
            </div>

            <!-- Sin resultados -->
            <div id="sin-resultados" class="hidden text-center py-16">
                <div class="text-6xl mb-4">📁</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron categorías</h3>
                <p class="text-gray-600">Intenta cambiar los filtros o crear una nueva categoría</p>
            </div>
        </div>

        <!-- Paginación -->
        <div id="pagination-container" class="mt-6 flex justify-center">
            <!-- Se llenará dinámicamente -->
        </div>

    </main>

    <!-- Modal Crear/Editar -->
    <div id="modal-categoria" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900" id="modal-title">
                        Nueva Categoría
                    </h3>
                    <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
                </div>

                <form id="form-categoria" class="space-y-4">
                    <input type="hidden" id="categoria-id">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre *</label>
                        <input 
                            type="text" 
                            id="categoria-nombre"
                            required
                            maxlength="100"
                            placeholder="Ej: Plomería"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>


                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                        <textarea 
                            id="categoria-descripcion"
                            rows="3"
                            maxlength="500"
                            placeholder="Describe brevemente esta categoría..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        ></textarea>
                    </div>

                    <div class="flex gap-4 mt-6">
                        <button 
                            type="submit"
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg transition-all"
                        >
                            Guardar
                        </button>
                        <button 
                            type="button"
                            onclick="cerrarModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-all"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>

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
            dismissible: true
        });

        const API_URL = 'http://localhost:8000/api';
        const ADMIN_API_URL = 'http://localhost:8000/admin/api';
        const authToken = localStorage.getItem('auth_token');
        
        let paginaActual = 1;
        let filtros = {
            search: '',
            activa: ''
        };

        // Verificar autenticación
        async function verificarAutenticacion() {
            const userRole = localStorage.getItem('user_role');
            
            if (!authToken || userRole !== 'admin') {
                window.location.href = '/login';
                return false;
            }

            try {
                const response = await fetch(`${API_URL}/auth/me`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Token inválido');

                const data = await response.json();
                const roleName = data.data?.role?.name || data.role?.name;
                
                if (!roleName || roleName !== 'admin') {
                    localStorage.clear();
                    window.location.href = '/login';
                    return false;
                }

                return true;

            } catch (error) {
                console.error('Error de autenticación:', error);
                localStorage.clear();
                window.location.href = '/login';
                return false;
            }
        }

        // Cargar categorías
        async function cargarCategorias(pagina = 1) {
            try {
                const params = new URLSearchParams({
                    page: pagina,
                    per_page: 20,
                    ...filtros
                });

                const response = await fetch(`${ADMIN_API_URL}/categorias?${params}`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Error al cargar categorías');

                const data = await response.json();
                
                if (data.success) {
                    mostrarCategorias(data.categorias);
                    actualizarStats(data.categorias);
                } else {
                    throw new Error(data.message);
                }

            } catch (error) {
                console.error('Error:', error);
                notyf.error('Error al cargar las categorías');
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('sin-resultados').classList.remove('hidden');
            }
        }

        // Mostrar categorías en tabla
        function mostrarCategorias(paginacion) {
            const tbody = document.getElementById('categorias-tbody');
            const loading = document.getElementById('loading');
            const sinResultados = document.getElementById('sin-resultados');

            loading.classList.add('hidden');

            if (!paginacion.data || paginacion.data.length === 0) {
                tbody.innerHTML = '';
                sinResultados.classList.remove('hidden');
                return;
            }

            sinResultados.classList.add('hidden');
            tbody.innerHTML = '';

            paginacion.data.forEach(categoria => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50';
                
                const estadoBadge = categoria.activa
                    ? '<span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Activa</span>'
                    : '<span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Inactiva</span>';

                tr.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">${categoria.nombre}</div>
                        <div class="text-xs text-gray-500">${categoria.slug}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-700 max-w-md truncate">${categoria.descripcion || '-'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            ${categoria.empresas_count} empresas
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${estadoBadge}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <button 
                            onclick='editarCategoria(${JSON.stringify(categoria).replace(/'/g, "\\'")})'
                            class="text-blue-600 hover:text-blue-900"
                            title="Editar"
                        >
                            ✏️
                        </button>
                        <button 
                            onclick="toggleEstado(${categoria.id}, ${categoria.activa})"
                            class="text-yellow-600 hover:text-yellow-900"
                            title="${categoria.activa ? 'Desactivar' : 'Activar'}"
                        >
                            ${categoria.activa ? '🔒' : '🔓'}
                        </button>
                        <button 
                            onclick="eliminarCategoria(${categoria.id}, '${categoria.nombre}', ${categoria.empresas_count})"
                            class="text-red-600 hover:text-red-900"
                            title="Eliminar"
                        >
                            🗑️
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });

            // Generar paginación
            generarPaginacion(paginacion);
        }

        // Actualizar stats
        function actualizarStats(paginacion) {
            document.getElementById('total-categorias').textContent = paginacion.total || 0;
            
            const activas = paginacion.data?.filter(c => c.activa).length || 0;
            document.getElementById('categorias-activas').textContent = activas;
        }

        // Generar paginación
        function generarPaginacion(paginacion) {
            const container = document.getElementById('pagination-container');
            
            if (paginacion.last_page <= 1) {
                container.innerHTML = '';
                return;
            }

            let html = '<div class="flex gap-2">';

            // Anterior
            if (paginacion.current_page > 1) {
                html += `<button onclick="cargarCategorias(${paginacion.current_page - 1})" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Anterior</button>`;
            }

            // Páginas
            for (let i = 1; i <= paginacion.last_page; i++) {
                if (i === paginacion.current_page) {
                    html += `<button class="px-4 py-2 bg-purple-600 text-white rounded-lg">${i}</button>`;
                } else {
                    html += `<button onclick="cargarCategorias(${i})" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">${i}</button>`;
                }
            }

            // Siguiente
            if (paginacion.current_page < paginacion.last_page) {
                html += `<button onclick="cargarCategorias(${paginacion.current_page + 1})" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Siguiente</button>`;
            }

            html += '</div>';
            container.innerHTML = html;
        }

        // Mostrar modal crear
        function mostrarModalCrear() {
            document.getElementById('modal-title').textContent = 'Nueva Categoría';
            document.getElementById('categoria-id').value = '';
            document.getElementById('form-categoria').reset();
            document.getElementById('modal-categoria').classList.remove('hidden');
        }

        // Editar categoría
        function editarCategoria(categoria) {
            document.getElementById('modal-title').textContent = 'Editar Categoría';
            document.getElementById('categoria-id').value = categoria.id;
            document.getElementById('categoria-nombre').value = categoria.nombre;
            document.getElementById('categoria-descripcion').value = categoria.descripcion || '';
            document.getElementById('modal-categoria').classList.remove('hidden');
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal-categoria').classList.add('hidden');
            document.getElementById('form-categoria').reset();
        }

        // Guardar categoría
        document.getElementById('form-categoria').addEventListener('submit', async function(e) {
            e.preventDefault();

            const id = document.getElementById('categoria-id').value;
            const nombre = document.getElementById('categoria-nombre').value.trim();
            const descripcion = document.getElementById('categoria-descripcion').value.trim();

            if (!nombre) {
                notyf.error('El nombre es obligatorio');
                return;
            }

            try {
                const url = id 
                    ? `${ADMIN_API_URL}/categorias/${id}`
                    : `${ADMIN_API_URL}/categorias`;

                const method = id ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ nombre, descripcion })
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success(data.message);
                    cerrarModal();
                    cargarCategorias(paginaActual);
                } else {
                    if (data.errors) {
                        Object.values(data.errors).forEach(error => {
                            notyf.error(error[0]);
                        });
                    } else {
                        notyf.error(data.message);
                    }
                }

            } catch (error) {
                console.error('Error:', error);
                notyf.error('Error al guardar la categoría');
            }
        });

        // Toggle estado
        async function toggleEstado(id, estadoActual) {
            const accion = estadoActual ? 'desactivar' : 'activar';
            
            if (!confirm(`¿Estás seguro de ${accion} esta categoría?`)) return;

            try {
                const response = await fetch(`${ADMIN_API_URL}/categorias/${id}/toggle-estado`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success(data.message);
                    cargarCategorias(paginaActual);
                } else {
                    notyf.error(data.message);
                }

            } catch (error) {
                console.error('Error:', error);
                notyf.error('Error al cambiar el estado');
            }
        }

        // Eliminar categoría
        async function eliminarCategoria(id, nombre, empresasCount) {
            if (empresasCount > 0) {
                notyf.error(`No se puede eliminar "${nombre}" porque tiene ${empresasCount} empresa(s) asociada(s)`);
                return;
            }

            if (!confirm(`¿Estás seguro de eliminar la categoría "${nombre}"?\n\nEsta acción no se puede deshacer.`)) return;

            try {
                const response = await fetch(`${ADMIN_API_URL}/categorias/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success(data.message);
                    cargarCategorias(paginaActual);
                } else {
                    notyf.error(data.message);
                }

            } catch (error) {
                console.error('Error:', error);
                notyf.error('Error al eliminar la categoría');
            }
        }

        // Aplicar filtros
        function aplicarFiltros() {
            filtros.search = document.getElementById('search').value.trim();
            filtros.activa = document.getElementById('filter-estado').value;
            paginaActual = 1;
            cargarCategorias(1);
        }

        // Limpiar filtros
        function limpiarFiltros() {
            document.getElementById('search').value = '';
            document.getElementById('filter-estado').value = '';
            filtros = { search: '', activa: '' };
            paginaActual = 1;
            cargarCategorias(1);
        }

        // Búsqueda en tiempo real (con debounce)
        let searchTimeout;
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                aplicarFiltros();
            }, 500);
        });

        // Cerrar sesión
        function cerrarSesion() {
            localStorage.clear();
            notyf.success('Sesión cerrada exitosamente');
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
        }

        // Inicializar
        document.addEventListener('DOMContentLoaded', async () => {
            const isAuthenticated = await verificarAutenticacion();
            
            if (!isAuthenticated) return;

            await cargarCategorias();
        });
    </script>

</body>
</html>

