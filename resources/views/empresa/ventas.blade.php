<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas y Órdenes - MERCAROF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'mercarof-navy': '#003B5C',
                        'mercarof-navy-dark': '#002942',
                        'mercarof-cyan': '#00A3E0',
                        'mercarof-cyan-dark': '#0082B8',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%); }
        .main-bg { background-color: #f8fafc; }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <a href="/dashboard/empresa" class="text-xl font-bold text-mercarof-navy">MERCAROF</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-600 font-medium">Ventas y Órdenes</span>
                </div>
                <a href="/dashboard/empresa" class="text-gray-600 hover:text-mercarof-cyan transition-colors font-medium text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header de página -->
        <div class="gradient-bg rounded-2xl p-6 text-white mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <span class="text-3xl">📊</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Ventas y Órdenes</h1>
                        <p class="text-white/80">Gestiona los pedidos de tus clientes</p>
                    </div>
                </div>
                <div class="flex gap-3 flex-wrap">
                    <!-- Filtro estado -->
                    <select id="filtro-estado" onchange="cargarOrdenes()" class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white border border-white/30 rounded-xl focus:ring-2 focus:ring-white/50 cursor-pointer">
                        <option value="todos" class="text-gray-900">Todos los estados</option>
                        <option value="pendiente" class="text-gray-900">⏳ Pendientes</option>
                        <option value="pagado" class="text-gray-900">💳 Por confirmar</option>
                        <option value="confirmado" class="text-gray-900">✓ Confirmados</option>
                        <option value="completado" class="text-gray-900">✅ Completados</option>
                        <option value="cancelado" class="text-gray-900">❌ Cancelados</option>
                    </select>
                    <!-- Items por página -->
                    <select id="items-por-pagina" onchange="cargarOrdenes()" class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white border border-white/30 rounded-xl focus:ring-2 focus:ring-white/50 cursor-pointer">
                        <option value="25" class="text-gray-900">25 por página</option>
                        <option value="100" class="text-gray-900">100 por página</option>
                        <option value="500" class="text-gray-900">500 por página</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border-l-4 border-gray-400">
                <p class="text-3xl font-bold text-gray-900" id="stat-total">0</p>
                <p class="text-sm text-gray-500 mt-1">Total Órdenes</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border-l-4 border-yellow-400">
                <p class="text-3xl font-bold text-yellow-600" id="stat-pendientes">0</p>
                <p class="text-sm text-gray-500 mt-1">Pendientes</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border-l-4 border-blue-400">
                <p class="text-3xl font-bold text-blue-600" id="stat-pagadas">0</p>
                <p class="text-sm text-gray-500 mt-1">Por Confirmar</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border-l-4 border-green-400">
                <p class="text-3xl font-bold text-green-600" id="stat-completadas">0</p>
                <p class="text-sm text-gray-500 mt-1">Completadas</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center border-l-4 border-mercarof-cyan">
                <p class="text-3xl font-bold text-mercarof-navy" id="stat-monto">$0</p>
                <p class="text-sm text-gray-500 mt-1">Ingresos</p>
            </div>
        </div>

        <!-- Tabla de Órdenes -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Lista de Órdenes</h3>
                <span id="info-paginacion" class="text-sm text-gray-500"></span>
            </div>
            
            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Orden</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Servicios</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Método</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-ordenes" class="divide-y divide-gray-100">
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                                <div class="animate-spin w-8 h-8 border-4 border-mercarof-cyan border-t-transparent rounded-full mx-auto mb-4"></div>
                                Cargando órdenes...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                <button id="btn-anterior" onclick="paginaAnterior()" disabled class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-300 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Anterior
                </button>
                <div id="numeros-pagina" class="flex gap-2">
                    <!-- Se llena dinámicamente -->
                </div>
                <button id="btn-siguiente" onclick="paginaSiguiente()" disabled class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-300 transition-colors flex items-center gap-2">
                    Siguiente
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

    </div>

    <!-- Modal Detalle Orden -->
    <div id="modal-orden" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b bg-gradient-to-r from-mercarof-navy to-mercarof-cyan">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Detalle de Orden</h3>
                    <button onclick="cerrarModal()" class="text-white/80 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="modal-orden-contenido" class="p-6">
                <!-- Se llena dinámicamente -->
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = null;
        let todasLasOrdenes = [];
        let paginaActual = 1;
        let totalPaginas = 1;

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const userRole = localStorage.getItem('user_role');

            if (!authToken || userRole !== 'empresa') {
                window.location.href = '/login';
                return;
            }

            await cargarOrdenes();
        });

        async function cargarOrdenes() {
            const filtro = document.getElementById('filtro-estado').value;

            try {
                const response = await fetch(`${API_URL}/empresa/ordenes?estado=${filtro}`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    todasLasOrdenes = result.data || [];
                    
                    // Stats
                    document.getElementById('stat-total').textContent = result.stats.total;
                    document.getElementById('stat-pendientes').textContent = result.stats.pendientes;
                    document.getElementById('stat-pagadas').textContent = result.stats.pagadas;
                    document.getElementById('stat-completadas').textContent = result.stats.completadas;
                    document.getElementById('stat-monto').textContent = '$' + parseFloat(result.stats.monto_total || 0).toFixed(2);

                    // Resetear a página 1 y renderizar
                    paginaActual = 1;
                    renderizarTabla();
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('tabla-ordenes').innerHTML = '<tr><td colspan="8" class="px-4 py-12 text-center text-red-500">Error al cargar órdenes</td></tr>';
            }
        }

        function renderizarTabla() {
            const itemsPorPagina = parseInt(document.getElementById('items-por-pagina').value);
            const inicio = (paginaActual - 1) * itemsPorPagina;
            const fin = inicio + itemsPorPagina;
            const ordenesPagina = todasLasOrdenes.slice(inicio, fin);
            
            totalPaginas = Math.ceil(todasLasOrdenes.length / itemsPorPagina);
            
            const tbody = document.getElementById('tabla-ordenes');

            if (ordenesPagina.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center">
                            <div class="text-5xl mb-4">📦</div>
                            <p class="text-gray-500 text-lg">No hay órdenes que mostrar</p>
                            <p class="text-gray-400 text-sm mt-2">Las órdenes de tus clientes aparecerán aquí</p>
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = ordenesPagina.map(orden => `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <span class="font-mono text-sm text-gray-600">${orden.numero_orden}</span>
                        </td>
                        <td class="px-4 py-4">
                            <p class="font-semibold text-gray-900">${orden.user?.name || 'N/A'}</p>
                            <p class="text-xs text-gray-500">${orden.user?.email || ''}</p>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-gray-600">${orden.items?.length || 0} servicio(s)</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold ${getEstadoClasses(orden.estado)}">
                                ${getEstadoLabel(orden.estado)}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-gray-600">${getMetodoPagoLabel(orden.metodo_pago)}</span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <span class="font-bold text-mercarof-navy">$${parseFloat(orden.total).toFixed(2)}</span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <span class="text-sm text-gray-500">${new Date(orden.created_at).toLocaleDateString('es-ES')}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="verOrden(${orden.id})" class="p-2 text-gray-500 hover:text-mercarof-cyan hover:bg-gray-100 rounded-lg transition-colors" title="Ver detalle">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                ${orden.estado === 'pagado' ? `
                                    <button onclick="confirmarOrden(${orden.id})" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition-colors">
                                        ✓ Confirmar
                                    </button>
                                ` : ''}
                                ${orden.estado === 'confirmado' ? `
                                    <button onclick="completarOrden(${orden.id})" class="px-3 py-1 bg-mercarof-cyan hover:bg-mercarof-cyan-dark text-white text-xs font-bold rounded-lg transition-colors">
                                        ✓ Completar
                                    </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `).join('');
            }

            // Actualizar info de paginación
            const infoInicio = todasLasOrdenes.length > 0 ? inicio + 1 : 0;
            const infoFin = Math.min(fin, todasLasOrdenes.length);
            document.getElementById('info-paginacion').textContent = `Mostrando ${infoInicio}-${infoFin} de ${todasLasOrdenes.length} órdenes`;

            // Actualizar botones de paginación
            document.getElementById('btn-anterior').disabled = paginaActual === 1;
            document.getElementById('btn-siguiente').disabled = paginaActual >= totalPaginas;

            // Renderizar números de página
            renderizarNumerosPagina();
        }

        function renderizarNumerosPagina() {
            const container = document.getElementById('numeros-pagina');
            let html = '';

            const maxBotones = 5;
            let inicio = Math.max(1, paginaActual - Math.floor(maxBotones / 2));
            let fin = Math.min(totalPaginas, inicio + maxBotones - 1);

            if (fin - inicio + 1 < maxBotones) {
                inicio = Math.max(1, fin - maxBotones + 1);
            }

            if (inicio > 1) {
                html += `<button onclick="irAPagina(1)" class="px-3 py-1 rounded-lg hover:bg-gray-200 transition-colors">1</button>`;
                if (inicio > 2) html += `<span class="px-2 text-gray-400">...</span>`;
            }

            for (let i = inicio; i <= fin; i++) {
                const activo = i === paginaActual ? 'bg-mercarof-cyan text-white' : 'hover:bg-gray-200';
                html += `<button onclick="irAPagina(${i})" class="px-3 py-1 rounded-lg ${activo} transition-colors">${i}</button>`;
            }

            if (fin < totalPaginas) {
                if (fin < totalPaginas - 1) html += `<span class="px-2 text-gray-400">...</span>`;
                html += `<button onclick="irAPagina(${totalPaginas})" class="px-3 py-1 rounded-lg hover:bg-gray-200 transition-colors">${totalPaginas}</button>`;
            }

            container.innerHTML = html;
        }

        function irAPagina(num) {
            paginaActual = num;
            renderizarTabla();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function paginaAnterior() {
            if (paginaActual > 1) {
                paginaActual--;
                renderizarTabla();
            }
        }

        function paginaSiguiente() {
            if (paginaActual < totalPaginas) {
                paginaActual++;
                renderizarTabla();
            }
        }

        function verOrden(ordenId) {
            const orden = todasLasOrdenes.find(o => o.id === ordenId);
            if (!orden) return;

            const contenido = document.getElementById('modal-orden-contenido');
            contenido.innerHTML = `
                <div class="space-y-6">
                    <!-- Info orden -->
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-500">Número de orden</p>
                            <p class="font-mono font-bold text-lg">${orden.numero_orden}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold ${getEstadoClasses(orden.estado)}">
                            ${getEstadoLabel(orden.estado)}
                        </span>
                    </div>

                    <!-- Cliente -->
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Cliente</p>
                        <p class="font-bold text-gray-900">${orden.user?.name || 'N/A'}</p>
                        <p class="text-sm text-gray-600">${orden.user?.email || ''}</p>
                    </div>

                    <!-- Items -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Servicios</p>
                        <div class="space-y-2">
                            ${(orden.items || []).map(item => `
                                <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-semibold text-gray-900">${item.nombre_servicio}${item.cantidad > 1 ? ' ×' + item.cantidad : ''}</p>
                                        ${item.descripcion_servicio ? `<p class="text-xs text-gray-500">${item.descripcion_servicio}</p>` : ''}
                                    </div>
                                    <p class="font-bold text-mercarof-cyan">$${parseFloat(item.precio).toFixed(2)}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>

                    <!-- Método de pago -->
                    ${orden.metodo_pago ? `
                        <div class="p-4 bg-blue-50 rounded-xl">
                            <p class="text-xs text-blue-600 mb-1">Método de pago</p>
                            <p class="font-bold text-blue-900">${getMetodoPagoLabel(orden.metodo_pago)}</p>
                            ${orden.referencia_pago ? `<p class="text-sm text-blue-700">Ref: ${orden.referencia_pago}</p>` : ''}
                        </div>
                    ` : ''}

                    <!-- Comprobante -->
                    ${orden.comprobante_pago ? `
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Comprobante de pago</p>
                            <a href="${orden.comprobante_pago}" target="_blank" class="inline-flex items-center gap-2 text-mercarof-cyan hover:underline">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                Ver comprobante
                            </a>
                        </div>
                    ` : ''}

                    <!-- Notas cliente -->
                    ${orden.notas_cliente ? `
                        <div class="p-4 bg-yellow-50 rounded-xl">
                            <p class="text-xs text-yellow-600 mb-1">Nota del cliente</p>
                            <p class="text-sm text-yellow-900">${orden.notas_cliente}</p>
                        </div>
                    ` : ''}

                    <!-- Total -->
                    <div class="flex justify-between items-center pt-4 border-t">
                        <div>
                            <p class="text-xs text-gray-500">Fecha</p>
                            <p class="text-sm text-gray-700">${new Date(orden.created_at).toLocaleString('es-ES')}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-mercarof-navy">$${parseFloat(orden.total).toFixed(2)}</p>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex gap-3">
                        ${orden.estado === 'pagado' ? `
                            <button onclick="confirmarOrden(${orden.id})" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-colors">
                                ✓ Confirmar Pago
                            </button>
                        ` : ''}
                        ${orden.estado === 'confirmado' ? `
                            <button onclick="completarOrden(${orden.id})" class="flex-1 bg-mercarof-cyan hover:bg-mercarof-cyan-dark text-white font-bold py-3 rounded-xl transition-colors">
                                ✓ Marcar Completado
                            </button>
                        ` : ''}
                        ${['pendiente', 'pagado'].includes(orden.estado) ? `
                            <button onclick="cancelarOrden(${orden.id})" class="px-6 bg-red-100 hover:bg-red-200 text-red-600 font-bold py-3 rounded-xl transition-colors">
                                Cancelar
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;

            document.getElementById('modal-orden').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-orden').classList.add('hidden');
        }

        async function confirmarOrden(ordenId) {
            if (!confirm('¿Confirmar que el pago fue recibido?')) return;

            try {
                const response = await fetch(`${API_URL}/empresa/ordenes/${ordenId}/confirmar`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    alert('✅ Pago confirmado exitosamente');
                    cerrarModal();
                    await cargarOrdenes();
                } else {
                    alert(result.message || 'Error al confirmar');
                }
            } catch (error) {
                alert('Error de conexión');
            }
        }

        async function completarOrden(ordenId) {
            if (!confirm('¿Marcar esta orden como completada?')) return;

            try {
                const response = await fetch(`${API_URL}/empresa/ordenes/${ordenId}/completar`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    alert('✅ Orden completada');
                    cerrarModal();
                    await cargarOrdenes();
                } else {
                    alert(result.message || 'Error al completar');
                }
            } catch (error) {
                alert('Error de conexión');
            }
        }

        async function cancelarOrden(ordenId) {
            if (!confirm('¿Estás seguro de cancelar esta orden?')) return;

            try {
                const response = await fetch(`${API_URL}/ordenes/${ordenId}/cancelar`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    alert('Orden cancelada');
                    cerrarModal();
                    await cargarOrdenes();
                } else {
                    alert(result.message || 'Error al cancelar');
                }
            } catch (error) {
                alert('Error de conexión');
            }
        }

        function getEstadoClasses(estado) {
            const classes = {
                'pendiente': 'bg-yellow-100 text-yellow-800',
                'pagado': 'bg-blue-100 text-blue-800',
                'confirmado': 'bg-cyan-100 text-cyan-800',
                'completado': 'bg-green-100 text-green-800',
                'cancelado': 'bg-red-100 text-red-800',
            };
            return classes[estado] || 'bg-gray-100 text-gray-800';
        }

        function getEstadoLabel(estado) {
            const labels = {
                'pendiente': '⏳ Pendiente',
                'pagado': '💳 Pagado',
                'confirmado': '✓ Confirmado',
                'completado': '✅ Completado',
                'cancelado': '❌ Cancelado',
            };
            return labels[estado] || estado;
        }

        function getMetodoPagoLabel(metodo) {
            if (!metodo) return '-';
            const labels = {
                'paypal': '💳 PayPal',
                'binance': '🪙 Binance',
                'transferencia': '🏦 Transferencia',
                'pago_movil': '📱 Pago Móvil',
            };
            return labels[metodo] || metodo;
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modal-orden').addEventListener('click', function(e) {
            if (e.target === this) cerrarModal();
        });
    </script>

</body>
</html>
