<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Suscripciones Pendientes - Admin ServiLocal</title>
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
                        💳 Suscripciones Pendientes de Aprobación
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

        <!-- Lista de Suscripciones Pendientes -->
        <div id="suscripciones-container" class="space-y-6">
            <!-- Se llenará dinámicamente -->
        </div>

        <!-- Loading -->
        <div id="loading" class="text-center py-16">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
            <p class="text-gray-600 mt-4">Cargando suscripciones...</p>
        </div>

        <!-- Sin resultados -->
        <div id="sin-resultados" class="hidden text-center py-16 bg-white rounded-lg shadow-md">
            <div class="text-6xl mb-4">✅</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">¡Todo al día!</h3>
            <p class="text-gray-600">No hay suscripciones pendientes de aprobación</p>
            <a href="/dashboard/admin" class="mt-4 inline-block text-purple-600 hover:text-purple-800 font-medium">
                ← Volver al dashboard
            </a>
        </div>

    </main>

    <!-- Modal de Detalle de Suscripción -->
    <div id="modal-detalle" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full p-8 max-h-[90vh] overflow-y-auto">
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">
                        💳 Detalle de Suscripción
                    </h3>
                    <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
                </div>

                <div id="modal-content" class="space-y-6">
                    <!-- Se llenará dinámicamente -->
                </div>

                <div class="mt-8 flex gap-4">
                    <button onclick="aprobarSuscripcion()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-all">
                        ✓ Aprobar Suscripción
                    </button>
                    <button onclick="mostrarFormularioRechazo()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition-all">
                        ✗ Rechazar
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal de Rechazo -->
    <div id="modal-rechazo" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-red-600">
                        ⚠️ Rechazar Suscripción
                    </h3>
                    <button onclick="cerrarModalRechazo()" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Motivo del Rechazo *
                    </label>
                    <textarea 
                        id="motivo-rechazo"
                        rows="5"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Explica por qué se rechaza esta suscripción (mínimo 10 caracteres)"
                    ></textarea>
                    <p class="text-sm text-gray-500 mt-2">
                        El motivo será notificado a la empresa.
                    </p>
                </div>

                <div class="flex gap-4">
                    <button onclick="cerrarModalRechazo()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-all">
                        Cancelar
                    </button>
                    <button onclick="confirmarRechazo()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition-all">
                        Confirmar Rechazo
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
            dismissible: true
        });

        const API_URL = 'http://localhost:8000/api';
        const ADMIN_API_URL = 'http://localhost:8000/admin/api';
        let suscripcionActual = null;
        const authToken = localStorage.getItem('auth_token');

        // Función para obtener badge de método de pago
        function getMetodoPagoBadge(metodo) {
            const metodos = {
                'banco': {
                    icono: '🏦',
                    nombre: 'Transferencia Bancaria',
                    color: 'bg-blue-100 text-blue-800 border-blue-300'
                },
                'binance': {
                    icono: '₿',
                    nombre: 'Binance Pay',
                    color: 'bg-yellow-100 text-yellow-800 border-yellow-300'
                },
                'paypal': {
                    icono: '💵',
                    nombre: 'PayPal',
                    color: 'bg-indigo-100 text-indigo-800 border-indigo-300'
                },
                'zelle': {
                    icono: '💸',
                    nombre: 'Zelle',
                    color: 'bg-purple-100 text-purple-800 border-purple-300'
                }
            };

            const info = metodos[metodo] || metodos['banco'];
            return `
                <span class="inline-flex items-center px-4 py-2 rounded-lg border-2 ${info.color} font-semibold text-sm">
                    <span class="text-xl mr-2">${info.icono}</span>
                    ${info.nombre}
                </span>
            `;
        }

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

                if (!response.ok) {
                    throw new Error('Token inválido');
                }

                const data = await response.json();
                
                // Verificar estructura correcta: data.data.role.name o data.role.name
                const roleName = data.data?.role?.name || data.role?.name;
                
                if (!roleName || roleName !== 'admin') {
                    console.warn('⚠️ Usuario no es admin:', roleName);
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

        // Cargar suscripciones pendientes
        async function cargarSuscripciones() {
            try {
                const response = await fetch(`${ADMIN_API_URL}/suscripciones/pendientes`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Error al cargar suscripciones');
                }

                const data = await response.json();
                
                if (data.success) {
                    mostrarSuscripciones(data.suscripciones || data);
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }

            } catch (error) {
                console.error('Error:', error);
                notyf.error('Error al cargar las suscripciones');
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('sin-resultados').classList.remove('hidden');
            }
        }

        // Mostrar suscripciones en el DOM
        function mostrarSuscripciones(suscripciones) {
            const container = document.getElementById('suscripciones-container');
            const loading = document.getElementById('loading');
            const sinResultados = document.getElementById('sin-resultados');
            const totalPendientes = document.getElementById('total-pendientes');

            loading.classList.add('hidden');

            // Aceptar tanto array directo como objeto con data
            const items = Array.isArray(suscripciones) ? suscripciones : (suscripciones.data || []);

            if (items.length === 0) {
                sinResultados.classList.remove('hidden');
                totalPendientes.textContent = '0';
                return;
            }

            totalPendientes.textContent = items.length;
            container.innerHTML = '';

            items.forEach(suscripcion => {
                const card = crearCardSuscripcion(suscripcion);
                container.appendChild(card);
            });
        }

        // Crear card de suscripción
        function crearCardSuscripcion(suscripcion) {
            const div = document.createElement('div');
            div.className = 'bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-all';
            
            const fechaSolicitud = new Date(suscripcion.created_at).toLocaleDateString('es-ES');
            const tipoPeriodo = suscripcion.tipo_periodo === 'mensual' ? 'Mensual' : 'Anual';
            const precio = suscripcion.precio_pagado;

            div.innerHTML = `
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="text-xl font-bold text-gray-900">
                                ${suscripcion.empresa.nombre_comercial || suscripcion.empresa.nombre || 'Sin nombre'}
                            </h3>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                                ⏳ Pendiente
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Plan Solicitado</p>
                                <p class="font-semibold text-gray-900">${suscripcion.plan.nombre}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Periodo</p>
                                <p class="font-semibold text-gray-900">${tipoPeriodo}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Precio</p>
                                <p class="font-semibold text-green-600">$${precio}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Fecha de Solicitud</p>
                                <p class="font-semibold text-gray-900">${fechaSolicitud}</p>
                            </div>
                        </div>

                        <div class="flex gap-2 mb-3">
                            ${suscripcion.capture_pago ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">📷 Capture</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">❌ Sin Capture</span>'}
                            ${suscripcion.referencia_bancaria ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">🏦 Referencia</span>' : ''}
                        </div>
                    </div>

                    <div class="ml-4">
                        <button 
                            onclick='verDetalle(${JSON.stringify(suscripcion).replace(/'/g, "\\'")})' 
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg transition-all"
                        >
                            Ver Detalle y Aprobar
                        </button>
                    </div>
                </div>
            `;

            return div;
        }

        // Ver detalle de suscripción
        function verDetalle(suscripcion) {
            suscripcionActual = suscripcion;
            const modal = document.getElementById('modal-detalle');
            const content = document.getElementById('modal-content');

            const fechaPago = suscripcion.fecha_pago 
                ? new Date(suscripcion.fecha_pago).toLocaleDateString('es-ES')
                : 'No especificada';

            content.innerHTML = `
                <!-- Información de la Empresa -->
                <div class="bg-purple-50 rounded-lg p-6">
                    <h4 class="font-bold text-lg text-gray-900 mb-4">🏢 Información de la Empresa</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nombre</p>
                            <p class="font-semibold text-gray-900">${suscripcion.empresa.nombre}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">RIF</p>
                            <p class="font-semibold text-gray-900">${suscripcion.empresa.rif || 'N/A'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold text-gray-900">${suscripcion.empresa.email || 'N/A'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Teléfono</p>
                            <p class="font-semibold text-gray-900">${suscripcion.empresa.telefono || 'N/A'}</p>
                        </div>
                    </div>
                </div>

                <!-- Información del Plan -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h4 class="font-bold text-lg text-gray-900 mb-4">📋 Plan Solicitado</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Plan</p>
                            <p class="font-semibold text-gray-900">${suscripcion.plan.nombre}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Periodo</p>
                            <p class="font-semibold text-gray-900">${suscripcion.tipo_periodo === 'mensual' ? 'Mensual' : 'Anual'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Precio</p>
                            <p class="font-semibold text-green-600 text-xl">$${suscripcion.precio_pagado}</p>
                        </div>
                    </div>
                </div>

                <!-- Método de Pago -->
                <div class="bg-indigo-50 rounded-lg p-4 mb-4">
                    <h5 class="font-semibold text-gray-700 mb-2">💳 Método de Pago:</h5>
                    ${getMetodoPagoBadge(suscripcion.metodo_pago || 'banco')}
                </div>

                <!-- Información de Pago -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h4 class="font-bold text-lg text-gray-900 mb-4">💰 Información de Pago</h4>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Nombre del Pagador</p>
                            <p class="font-semibold text-gray-900">${suscripcion.nombre_empresa_pagadora || 'No especificado'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">RIF del Pagador</p>
                            <p class="font-semibold text-gray-900">${suscripcion.rif_pagador || 'No especificado'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Referencia Bancaria</p>
                            <p class="font-semibold text-gray-900">${suscripcion.referencia_bancaria || 'No especificada'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fecha de Pago</p>
                            <p class="font-semibold text-gray-900">${fechaPago}</p>
                        </div>
                    </div>

                    ${suscripcion.capture_pago ? `
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Capture de Pago</p>
                            <img 
                                src="/storage/${suscripcion.capture_pago}" 
                                alt="Capture de pago"
                                class="max-w-full h-auto rounded-lg border-2 border-gray-300 cursor-pointer hover:border-purple-500 transition-all"
                                onclick="window.open('/storage/${suscripcion.capture_pago}', '_blank')"
                            />
                            <p class="text-xs text-gray-500 mt-2">Haz clic en la imagen para verla en tamaño completo</p>
                        </div>
                    ` : `
                        <div class="bg-red-100 border border-red-300 rounded-lg p-4 text-center">
                            <p class="text-red-700 font-semibold">⚠️ No se ha proporcionado capture de pago</p>
                        </div>
                    `}
                </div>
            `;

            modal.classList.remove('hidden');
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal-detalle').classList.add('hidden');
            suscripcionActual = null;
        }

        // Mostrar modal de confirmación
        function aprobarSuscripcion() {
            if (!suscripcionActual) return;

            // Llenar información en el modal
            document.getElementById('modal-empresa-nombre').textContent = suscripcionActual.empresa.nombre_comercial || suscripcionActual.empresa.nombre || 'Sin nombre';
            document.getElementById('modal-plan-nombre').textContent = suscripcionActual.plan.nombre;
            document.getElementById('modal-monto').textContent = `$${parseFloat(suscripcionActual.precio_pagado).toFixed(2)}`;
            
            // Mostrar modal
            const modal = document.getElementById('modal-confirmar-aprobacion');
            modal.classList.remove('hidden');
            modal.classList.add('animate-fadeIn');
        }

        // Cerrar modal
        function cerrarModalAprobacion() {
            const modal = document.getElementById('modal-confirmar-aprobacion');
            modal.classList.add('hidden');
        }

        // Confirmar aprobación (ejecutar la aprobación real)
        async function confirmarAprobacion() {
            if (!suscripcionActual) return;

            // Cerrar modal
            cerrarModalAprobacion();

            try {
                const response = await fetch(`${ADMIN_API_URL}/suscripciones/${suscripcionActual.id}/aprobar`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success('✅ Suscripción aprobada exitosamente');
                    cerrarModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Error al aprobar');
                }

            } catch (error) {
                console.error('Error:', error);
                notyf.error(error.message || 'Error al aprobar la suscripción');
            }
        }

        // Mostrar formulario de rechazo
        function mostrarFormularioRechazo() {
            document.getElementById('modal-rechazo').classList.remove('hidden');
        }

        // Cerrar modal de rechazo
        function cerrarModalRechazo() {
            document.getElementById('modal-rechazo').classList.add('hidden');
            document.getElementById('motivo-rechazo').value = '';
        }

        // Confirmar rechazo
        async function confirmarRechazo() {
            if (!suscripcionActual) return;

            const motivo = document.getElementById('motivo-rechazo').value.trim();

            if (motivo.length < 10) {
                notyf.error('El motivo debe tener al menos 10 caracteres');
                return;
            }

            try {
                const response = await fetch(`${ADMIN_API_URL}/suscripciones/${suscripcionActual.id}/rechazar`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ motivo })
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success('Suscripción rechazada');
                    cerrarModalRechazo();
                    cerrarModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Error al rechazar');
                }

            } catch (error) {
                console.error('Error:', error);
                notyf.error(error.message || 'Error al rechazar la suscripción');
            }
        }

        // Cerrar sesión
        function cerrarSesion() {
            localStorage.clear(); // Limpiar todo el localStorage
            notyf.success('Sesión cerrada exitosamente');
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
        }

        // Inicializar
        document.addEventListener('DOMContentLoaded', async () => {
            const isAuthenticated = await verificarAutenticacion();
            
            if (!isAuthenticated) {
                return; // Ya fue redirigido al login
            }

            // Cargar suscripciones pendientes
            await cargarSuscripciones();
        });
    </script>

    <!-- Modal de Confirmación Mejorado -->
    <div id="modal-confirmar-aprobacion" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="if(event.target === this) cerrarModalAprobacion()">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-t-2xl">
                <div class="flex items-center justify-center w-16 h-16 bg-white rounded-full mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white text-center">Aprobar Suscripción</h3>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <p class="text-gray-600 text-center mb-6">
                    ¿Estás seguro de que deseas aprobar esta suscripción?
                </p>
                
                <!-- Información de la suscripción -->
                <div id="modal-suscripcion-info" class="bg-gray-50 rounded-lg p-4 mb-6 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Empresa:</span>
                        <span id="modal-empresa-nombre" class="font-semibold text-gray-900"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Plan:</span>
                        <span id="modal-plan-nombre" class="font-semibold text-purple-600"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Monto:</span>
                        <span id="modal-monto" class="font-semibold text-green-600"></span>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-blue-800">
                            El plan se activará <strong>inmediatamente</strong> y la empresa tendrá acceso completo a todas las funcionalidades.
                        </p>
                    </div>
                </div>
                
                <!-- Botones -->
                <div class="flex gap-3">
                    <button 
                        onclick="cerrarModalAprobacion()" 
                        class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-all duration-200 transform hover:scale-105"
                    >
                        Cancelar
                    </button>
                    <button 
                        onclick="confirmarAprobacion()" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg"
                    >
                        ✓ Aprobar
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

