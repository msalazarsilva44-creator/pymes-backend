<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Empresas Pendientes - Admin ServiLocal</title>
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

        /* Animación para modales */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
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
                        🔍 Empresas Pendientes de Aprobación
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

        <!-- Stats -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Total Pendientes</h2>
                    <p class="text-3xl font-bold text-orange-600" id="total-pendientes">0</p>
                </div>
                <div class="text-5xl">⏳</div>
            </div>
        </div>

        <!-- Lista de Empresas Pendientes -->
        <div id="empresas-container" class="space-y-6">
            <!-- Se llenará dinámicamente -->
        </div>

        <!-- Loading -->
        <div id="loading" class="text-center py-16">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
            <p class="text-gray-600 mt-4">Cargando empresas...</p>
        </div>

        <!-- Sin resultados -->
        <div id="sin-resultados" class="hidden text-center py-16 bg-white rounded-lg shadow-md">
            <div class="text-6xl mb-4">✅</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">¡Todo al día!</h3>
            <p class="text-gray-600">No hay empresas pendientes de verificación</p>
            <a href="/dashboard/admin" class="mt-4 inline-block text-purple-600 hover:text-purple-800 font-medium">
                ← Volver al dashboard
            </a>
        </div>

    </main>

    <!-- Modal de Detalle -->
    <div id="modal-detalle" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full relative">
                <!-- Header del Modal -->
                <div class="gradient-bg text-white p-6 rounded-t-lg">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Aprobación de Empresa</h2>
                        <button onclick="cerrarModal()" class="text-white hover:text-gray-200 text-2xl">×</button>
                    </div>
                </div>

                <!-- Contenido del Modal -->
                <div class="p-6 max-h-[70vh] overflow-y-auto" id="modal-content">
                    <!-- Se llenará dinámicamente -->
                </div>

                <!-- Footer del Modal -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end gap-3">
                    <button onclick="cerrarModal()" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition-all">
                        Cerrar
                    </button>
                    <button onclick="rechazarEmpresa()" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all">
                        ❌ Rechazar
                    </button>
                    <button onclick="aprobarEmpresa()" class="px-6 py-3 gradient-bg text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                        ✅ Aprobar
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
        const authToken = localStorage.getItem('auth_token');
        let empresaActual = null;

        // Verificar autenticación
        async function verificarAutenticacion() {
            const userRole = localStorage.getItem('user_role');
            
            if (!authToken || userRole !== 'admin') {
                console.warn('⚠️ No hay token o no es admin - Redirigiendo...');
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

                if (!response.ok || !(await response.json()).data?.role?.name === 'admin') {
                    localStorage.clear();
                    window.location.href = '/login';
                    return false;
                }

                return true;
            } catch (error) {
                console.error('Error verificando autenticación:', error);
                return false;
            }
        }

        // Cargar empresas pendientes (ahora con autenticación)
        async function cargarEmpresasPendientes() {
            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/pendientes`, {
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
                    throw new Error('Error cargando empresas');
                }

                const data = await response.json();

                if (data.success) {
                    document.getElementById('total-pendientes').textContent = data.data.length;
                    renderizarEmpresas(data.data);
                    document.getElementById('loading').classList.add('hidden');
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('loading').classList.add('hidden');
                notyf.error('❌ Error al cargar las empresas: ' + error.message);
            }
        }

        // Renderizar empresas
        function renderizarEmpresas(empresas) {
            const container = document.getElementById('empresas-container');
            const sinResultados = document.getElementById('sin-resultados');

            if (empresas.length === 0) {
                container.classList.add('hidden');
                sinResultados.classList.remove('hidden');
                return;
            }

            container.innerHTML = empresas.map(empresa => `
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-4xl">${empresa.categoria?.icono || '🏢'}</span>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">${empresa.nombre_comercial}</h3>
                                    <p class="text-sm text-gray-600">${empresa.categoria?.nombre || 'Sin categoría'}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">RIF</p>
                                    <p class="font-medium text-gray-900">${empresa.rfc || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Ubicación</p>
                                    <p class="font-medium text-gray-900">${empresa.ciudad?.nombre || 'N/A'} - ${empresa.municipio?.nombre || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium text-gray-900">${empresa.email_contacto || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Teléfono</p>
                                    <p class="font-medium text-gray-900">${empresa.telefono || 'N/A'}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Descripción</p>
                                <p class="text-gray-700 text-sm">${empresa.descripcion || 'Sin descripción'}</p>
                            </div>

                            <div class="flex items-center gap-2 text-sm">
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full font-medium">
                                    ⏳ Pendiente de aprobación
                                </span>
                                <span class="text-gray-500">
                                    Registrado: ${new Date(empresa.created_at).toLocaleDateString('es-VE')}
                                </span>
                            </div>
                        </div>

                        <div class="ml-6">
                            <button onclick="verDetalle(${empresa.id})" class="gradient-bg text-white font-semibold px-6 py-3 rounded-lg hover:shadow-lg transition-all whitespace-nowrap">
                                🔍 Ver Detalle
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Ver detalle
        async function verDetalle(empresaId) {
            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${empresaId}`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Error al cargar los detalles');
                }

                const data = await response.json();

                if (data.success) {
                    empresaActual = data.data;
                    mostrarModalDetalle(data.data);
                } else {
                    notyf.error('❌ Error al cargar los detalles: ' + (data.message || 'Error desconocido'));
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error al cargar los detalles: ' + error.message);
            }
        }

        // Mostrar modal con detalles
        function mostrarModalDetalle(empresa) {
            const modal = document.getElementById('modal-detalle');
            const content = document.getElementById('modal-content');

            content.innerHTML = `
                <!-- Información de la Empresa -->
                <div class="space-y-6">
                    
                    <!-- Header con logo -->
                    <div class="flex items-center gap-4 pb-6 border-b">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-blue-100 rounded-lg flex items-center justify-center text-4xl">
                            ${empresa.categoria?.icono || '🏢'}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">${empresa.nombre_comercial}</h3>
                            <p class="text-purple-600 font-medium">${empresa.categoria?.nombre || 'Sin categoría'}</p>
                        </div>
                    </div>

                    <!-- Información Básica -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">📋 Información Básica</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">RIF</p>
                                <p class="font-semibold text-gray-900">${empresa.rfc || 'N/A'}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Plan</p>
                                <p class="font-semibold text-gray-900">${empresa.plan?.nombre || 'N/A'}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Estado</p>
                                <p class="font-semibold text-gray-900">${empresa.ciudad?.nombre || 'N/A'}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Municipio</p>
                                <p class="font-semibold text-gray-900">${empresa.municipio?.nombre || 'N/A'}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500 mb-1">Dirección</p>
                                <p class="font-semibold text-gray-900">${empresa.direccion || 'N/A'}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">📞 Contacto</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Email</p>
                                <p class="font-semibold text-gray-900">${empresa.email_contacto || 'N/A'}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Teléfono</p>
                                <p class="font-semibold text-gray-900">${empresa.telefono || 'N/A'}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">📝 Descripción</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">${empresa.descripcion || 'Sin descripción'}</p>
                        </div>
                    </div>

                    <!-- Documento RIF -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">📄 Documento RIF</h4>
                        ${empresa.documento_rif ? `
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-4xl">📑</span>
                                        <div>
                                            <p class="font-semibold text-gray-900">Documento RIF.pdf</p>
                                            <p class="text-sm text-gray-600">Documento de verificación</p>
                                        </div>
                                    </div>
                                    <a href="/storage/${empresa.documento_rif}" target="_blank" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition-all">
                                        Ver PDF →
                                    </a>
                                </div>
                            </div>
                        ` : `
                            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                <p class="text-red-800">❌ No se subió documento RIF</p>
                            </div>
                        `}
                    </div>

                    <!-- Información del Usuario Responsable -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">👤 Usuario Responsable</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="font-semibold text-gray-900">${empresa.user?.name || 'N/A'}</p>
                            <p class="text-sm text-gray-600">${empresa.user?.email || 'N/A'}</p>
                            <p class="text-sm text-gray-600">Teléfono: ${empresa.user?.phone || 'N/A'}</p>
                        </div>
                    </div>

                    <!-- Fecha de Registro -->
                    <div>
                        <p class="text-sm text-gray-500">
                            📅 Registrado el ${new Date(empresa.created_at).toLocaleString('es-VE')}
                        </p>
                    </div>

                </div>
            `;

            modal.classList.remove('hidden');
        }

        // Mostrar modal de confirmación para aprobar
        function aprobarEmpresa() {
            if (!empresaActual) return;

            // Llenar información en el modal
            document.getElementById('modal-empresa-nombre-aprobar').textContent = empresaActual.nombre_comercial || 'Sin nombre';
            document.getElementById('modal-empresa-rif').textContent = empresaActual.rif || 'N/A';
            document.getElementById('modal-empresa-categoria').textContent = empresaActual.categoria?.nombre || 'N/A';
            document.getElementById('modal-empresa-ciudad').textContent = empresaActual.ciudad?.nombre || 'N/A';
            
            // Mostrar modal
            const modal = document.getElementById('modal-confirmar-aprobacion-empresa');
            modal.classList.remove('hidden');
            modal.classList.add('animate-fadeIn');
        }

        // Cerrar modal de aprobación
        function cerrarModalAprobacionEmpresa() {
            const modal = document.getElementById('modal-confirmar-aprobacion-empresa');
            modal.classList.add('hidden');
        }

        // Confirmar aprobación (ejecutar la aprobación real)
        async function confirmarAprobacionEmpresa() {
            if (!empresaActual) return;

            // Cerrar modal
            cerrarModalAprobacionEmpresa();

            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${empresaActual.id}/aprobar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ accion: 'aprobar' })
                });

                if (!response.ok) {
                    throw new Error('Error al aprobar la empresa');
                }

                const data = await response.json();

                if (data.success) {
                    notyf.success('✅ Empresa aprobada exitosamente. Ahora es visible en el marketplace');
                    cerrarModal();
                    await cargarEmpresasPendientes();
                } else {
                    notyf.error('❌ Error: ' + (data.message || 'No se pudo aprobar'));
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error de conexión: ' + error.message);
            }
        }

        // Rechazar empresa
        async function rechazarEmpresa() {
            if (!empresaActual) return;

            const motivo = prompt(`¿Por qué rechazas a "${empresaActual.nombre_comercial}"?\n\nEscribe el motivo del rechazo:`);
            
            if (!motivo || motivo.trim() === '') {
                notyf.warning('⚠️ Debes proporcionar un motivo para el rechazo');
                return;
            }

            try {
                const response = await fetch(`${ADMIN_API_URL}/empresas/${empresaActual.id}/aprobar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ 
                        accion: 'rechazar',
                        motivo: motivo.trim()
                    })
                });

                if (!response.ok) {
                    throw new Error('Error al rechazar la empresa');
                }

                const data = await response.json();

                if (data.success) {
                    notyf.error('Empresa rechazada. Se ha notificado al usuario');
                    cerrarModal();
                    await cargarEmpresasPendientes();
                } else {
                    notyf.error('❌ Error: ' + (data.message || 'No se pudo rechazar'));
                }
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error de conexión: ' + error.message);
            }
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal-detalle').classList.add('hidden');
            empresaActual = null;
        }

        // Cerrar sesión
        function cerrarSesion() {
            if (confirm('¿Estás seguro de cerrar sesión?')) {
                localStorage.clear();
                window.location.href = '/login';
            }
        }

        // Cargar datos al iniciar
        document.addEventListener('DOMContentLoaded', async () => {
            // Verificar autenticación primero
            const isAuthenticated = await verificarAutenticacion();
            
            if (!isAuthenticated) {
                return; // Ya fue redirigido al login
            }

            // Cargar empresas pendientes
            await cargarEmpresasPendientes();
        });
    </script>

    <!-- Modal de Confirmación para Aprobar Empresa -->
    <div id="modal-confirmar-aprobacion-empresa" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="if(event.target === this) cerrarModalAprobacionEmpresa()">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 rounded-t-2xl">
                <div class="flex items-center justify-center w-16 h-16 bg-white rounded-full mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white text-center">Aprobar Empresa</h3>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <p class="text-gray-600 text-center mb-6">
                    ¿Estás seguro de que deseas aprobar esta empresa?
                </p>
                
                <!-- Información de la empresa -->
                <div id="modal-empresa-info-aprobar" class="bg-gray-50 rounded-lg p-4 mb-6 space-y-3">
                    <div class="flex justify-between items-start">
                        <span class="text-sm text-gray-600">Empresa:</span>
                        <span id="modal-empresa-nombre-aprobar" class="font-semibold text-gray-900 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">RIF:</span>
                        <span id="modal-empresa-rif" class="font-semibold text-gray-700"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Categoría:</span>
                        <span id="modal-empresa-categoria" class="font-semibold text-purple-600"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Ciudad:</span>
                        <span id="modal-empresa-ciudad" class="font-semibold text-blue-600"></span>
                    </div>
                </div>

                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-green-800">
                            La empresa será <strong>visible en el marketplace</strong> inmediatamente y los clientes podrán encontrarla y contactarla.
                        </p>
                    </div>
                </div>
                
                <!-- Botones -->
                <div class="flex gap-3">
                    <button 
                        onclick="cerrarModalAprobacionEmpresa()" 
                        class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-all duration-200 transform hover:scale-105"
                    >
                        Cancelar
                    </button>
                    <button 
                        onclick="confirmarAprobacionEmpresa()" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg"
                    >
                        ✓ Aprobar
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

