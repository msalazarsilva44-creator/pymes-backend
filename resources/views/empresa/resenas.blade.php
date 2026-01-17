<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reseñas - ServiLocal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .main-bg { background-color: #f3f4f6; }
        .star-filled { color: #fbbf24; }
        .star-empty { color: #d1d5db; }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-md border-b-2 border-purple-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="/dashboard/empresa" class="text-2xl font-bold gradient-bg bg-clip-text text-transparent">ServiLocal</a>
                <a href="/dashboard/empresa" class="text-gray-600 hover:text-purple-600 transition-colors font-medium">← Volver al Dashboard</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header con Stats -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">💬 Gestión de Reseñas</h1>
            <p class="text-gray-600">Responde a tus clientes y mejora tu reputación</p>
        </div>

        <!-- KPIs Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Reseñas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">📝 Total Reseñas</span>
                </div>
                <p class="text-3xl font-bold text-gray-900" id="stat-total-resenas">0</p>
                <p class="text-xs text-gray-500 mt-1">Todas las valoraciones</p>
            </div>

            <!-- Pendientes -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">⏳ Sin Responder</span>
                    <span id="badge-pendientes" class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">0</span>
                </div>
                <p class="text-3xl font-bold text-orange-600" id="stat-pendientes">0</p>
                <p class="text-xs text-gray-500 mt-1">Requieren tu atención</p>
            </div>

            <!-- Rating Promedio -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">⭐ Rating</span>
                </div>
                <p class="text-3xl font-bold text-yellow-500" id="stat-rating">0.0</p>
                <div id="stars-display" class="mt-1"></div>
            </div>

            <!-- Tiempo de Respuesta -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">⚡ T. Respuesta</span>
                </div>
                <p class="text-3xl font-bold text-blue-600" id="stat-tiempo-respuesta">-</p>
                <p class="text-xs text-gray-500 mt-1">Promedio en horas</p>
            </div>
        </div>

        <!-- Distribución de Calificaciones -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">📊 Distribución de Calificaciones</h2>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700 w-12">5 ⭐</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div id="bar-5" class="bg-green-500 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <span id="count-5" class="text-sm font-semibold text-gray-900 w-12 text-right">0</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700 w-12">4 ⭐</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div id="bar-4" class="bg-blue-500 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <span id="count-4" class="text-sm font-semibold text-gray-900 w-12 text-right">0</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700 w-12">3 ⭐</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div id="bar-3" class="bg-yellow-500 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <span id="count-3" class="text-sm font-semibold text-gray-900 w-12 text-right">0</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700 w-12">2 ⭐</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div id="bar-2" class="bg-orange-500 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <span id="count-2" class="text-sm font-semibold text-gray-900 w-12 text-right">0</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700 w-12">1 ⭐</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div id="bar-1" class="bg-red-500 h-3 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <span id="count-1" class="text-sm font-semibold text-gray-900 w-12 text-right">0</span>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-wrap gap-3">
                <button onclick="filtrarResenas('todas')" id="btn-todas" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all">
                    Todas
                </button>
                <button onclick="filtrarResenas('pendientes')" id="btn-pendientes" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all">
                    Sin Responder
                </button>
                <button onclick="filtrarResenas(5)" id="btn-5-estrellas" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all">
                    5 ⭐
                </button>
                <button onclick="filtrarResenas(4)" id="btn-4-estrellas" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all">
                    4 ⭐
                </button>
                <button onclick="filtrarResenas(3)" id="btn-3-estrellas" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all">
                    3 ⭐
                </button>
                <button onclick="filtrarResenas(2)" id="btn-2-estrellas" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all">
                    2 ⭐
                </button>
                <button onclick="filtrarResenas(1)" id="btn-1-estrellas" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all">
                    1 ⭐
                </button>
            </div>
        </div>

        <!-- Sugerencias Inteligentes -->
        <div id="sugerencias-container" class="mb-8"></div>

        <!-- Lista de Reseñas -->
        <div class="space-y-4" id="lista-resenas">
            <div class="text-center py-12 bg-white rounded-lg shadow-md">
                <span class="text-5xl mb-4 block">📭</span>
                <p class="text-gray-500">Cargando reseñas...</p>
            </div>
        </div>

    </div>

    <!-- Modal de Respuesta -->
    <div id="modal-respuesta" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="cerrarModal()">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-900">💬 Responder a Reseña</h3>
                <button onclick="cerrarModal()" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
            </div>
            
            <!-- Reseña Original -->
            <div id="resena-original" class="bg-gray-50 rounded-lg p-4 mb-6 border-l-4 border-purple-500">
                <!-- Se llena dinámicamente -->
            </div>
            
            <!-- Formulario de Respuesta -->
            <form id="form-respuesta" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tu Respuesta
                    </label>
                    <textarea 
                        id="textarea-respuesta" 
                        rows="5"
                        maxlength="500"
                        placeholder="Escribe tu respuesta profesional aquí..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                        required
                    ></textarea>
                    <div class="flex justify-between items-center mt-1">
                        <p class="text-xs text-gray-500">Sé profesional y constructivo</p>
                        <p class="text-xs text-gray-500"><span id="contador-caracteres">0</span>/500</p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="flex-1 gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all"
                    >
                        📤 Publicar Respuesta
                    </button>
                    <button 
                        type="button"
                        onclick="cerrarModal()"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all"
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = null;
        let empresaData = null;
        let todasLasResenas = [];
        let filtroActual = 'todas';
        let resenaActual = null;

        // Inicializar
        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const userRole = localStorage.getItem('user_role');

            if (!authToken || userRole !== 'empresa' || !empresaData.id) {
                window.location.href = '/login';
                return;
            }

            await cargarResenas();
            
            // Contador de caracteres
            document.getElementById('textarea-respuesta').addEventListener('input', (e) => {
                document.getElementById('contador-caracteres').textContent = e.target.value.length;
            });
        });

        // Cargar todas las reseñas
        async function cargarResenas() {
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaData.id}/resenas`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });

                const result = await response.json();
                
                if (result.success) {
                    todasLasResenas = result.data.data || result.data || [];
                    actualizarStats(todasLasResenas);
                    actualizarDistribucion(todasLasResenas);
                    mostrarSugerencias(todasLasResenas);
                    mostrarResenas(todasLasResenas);
                } else {
                    mostrarError('No se pudieron cargar las reseñas');
                }
            } catch (error) {
                console.error('Error cargando reseñas:', error);
                mostrarError('Error de conexión al cargar reseñas');
            }
        }

        // Actualizar stats
        function actualizarStats(resenas) {
            const total = resenas.length;
            const pendientes = resenas.filter(r => !r.respuesta_empresa).length;
            const calificaciones = resenas.map(r => r.calificacion);
            const promedio = calificaciones.length > 0 
                ? (calificaciones.reduce((a, b) => a + b, 0) / calificaciones.length).toFixed(1)
                : 0;

            document.getElementById('stat-total-resenas').textContent = total;
            document.getElementById('stat-pendientes').textContent = pendientes;
            document.getElementById('badge-pendientes').textContent = pendientes;
            document.getElementById('stat-rating').textContent = promedio;

            // Estrellas visuales
            const starsHTML = generarEstrellas(parseFloat(promedio));
            document.getElementById('stars-display').innerHTML = starsHTML;

            // Tiempo de respuesta (simulado por ahora)
            const respondidas = resenas.filter(r => r.respuesta_empresa && r.respondido_at);
            if (respondidas.length > 0) {
                // Calcular promedio de horas entre created_at y respondido_at
                let totalHoras = 0;
                respondidas.forEach(r => {
                    const created = new Date(r.created_at);
                    const responded = new Date(r.respondido_at);
                    const horas = Math.abs(responded - created) / 36e5; // ms a horas
                    totalHoras += horas;
                });
                const promHoras = (totalHoras / respondidas.length).toFixed(0);
                document.getElementById('stat-tiempo-respuesta').textContent = promHoras + 'h';
            } else {
                document.getElementById('stat-tiempo-respuesta').textContent = '-';
            }
        }

        // Actualizar distribución
        function actualizarDistribucion(resenas) {
            const total = resenas.length;
            const distribucion = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 };
            
            resenas.forEach(r => {
                if (distribucion[r.calificacion] !== undefined) {
                    distribucion[r.calificacion]++;
                }
            });

            for (let i = 1; i <= 5; i++) {
                const count = distribucion[i];
                const porcentaje = total > 0 ? (count / total) * 100 : 0;
                document.getElementById(`bar-${i}`).style.width = porcentaje + '%';
                document.getElementById(`count-${i}`).textContent = count;
            }
        }

        // Mostrar sugerencias
        function mostrarSugerencias(resenas) {
            const pendientes = resenas.filter(r => !r.respuesta_empresa);
            const container = document.getElementById('sugerencias-container');
            const sugerencias = [];

            if (pendientes.length > 5) {
                sugerencias.push({
                    icon: '⚠️',
                    text: `Tienes ${pendientes.length} reseñas sin responder. Responde en menos de 24 horas para mantener una buena reputación.`,
                    type: 'warning'
                });
            } else if (pendientes.length > 0) {
                sugerencias.push({
                    icon: '📝',
                    text: `Tienes ${pendientes.length} reseña(s) pendiente(s). Las empresas que responden tienen 2x más conversión.`,
                    type: 'info'
                });
            }

            const bajas = resenas.filter(r => r.calificacion <= 2 && !r.respuesta_empresa);
            if (bajas.length > 0) {
                sugerencias.push({
                    icon: '🔴',
                    text: `Tienes ${bajas.length} reseña(s) negativa(s) sin responder. Responde profesionalmente para mostrar que te importa.`,
                    type: 'error'
                });
            }

            if (resenas.length > 10 && pendientes.length === 0) {
                sugerencias.push({
                    icon: '🎉',
                    text: '¡Excelente! Has respondido todas tus reseñas. Esto genera confianza en tus clientes potenciales.',
                    type: 'success'
                });
            }

            if (sugerencias.length > 0) {
                container.innerHTML = `
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg shadow-md p-6 border-2 border-purple-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">💡 Sugerencias</h3>
                        <div class="space-y-3">
                            ${sugerencias.map(s => `
                                <div class="flex items-start gap-3 p-3 bg-white rounded-lg border-l-4 ${
                                    s.type === 'success' ? 'border-green-500' :
                                    s.type === 'warning' ? 'border-yellow-500' :
                                    s.type === 'error' ? 'border-red-500' :
                                    'border-blue-500'
                                }">
                                    <span class="text-2xl flex-shrink-0">${s.icon}</span>
                                    <p class="text-sm text-gray-700">${s.text}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = '';
            }
        }

        // Mostrar reseñas
        function mostrarResenas(resenas) {
            const container = document.getElementById('lista-resenas');
            
            if (resenas.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12 bg-white rounded-lg shadow-md">
                        <span class="text-5xl mb-4 block">📭</span>
                        <p class="text-gray-500 text-lg">No hay reseñas ${filtroActual !== 'todas' ? 'con este filtro' : 'aún'}</p>
                        <p class="text-gray-400 text-sm mt-2">Las reseñas de tus clientes aparecerán aquí</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = resenas.map(resena => `
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all">
                    <!-- Header de la reseña -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                ${(resena.user?.name || 'Usuario').charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">${resena.user?.name || 'Usuario Anónimo'}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    ${generarEstrellas(resena.calificacion)}
                                    <span class="text-sm text-gray-500">• ${formatFecha(resena.created_at)}</span>
                                </div>
                            </div>
                        </div>
                        ${!resena.respuesta_empresa ? 
                            '<span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">SIN RESPONDER</span>' : 
                            '<span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">✓ RESPONDIDA</span>'
                        }
                    </div>

                    <!-- Comentario del cliente -->
                    <div class="mb-4">
                        <p class="text-gray-700">${resena.comentario || '<em class="text-gray-400">Sin comentario</em>'}</p>
                    </div>

                    <!-- Respuesta de la empresa (si existe) -->
                    ${resena.respuesta_empresa ? `
                        <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500 mb-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-sm font-semibold text-purple-700">📢 Tu respuesta</span>
                                <span class="text-xs text-gray-500">• ${formatFecha(resena.respondido_at)}</span>
                            </div>
                            <p class="text-gray-700 text-sm">${resena.respuesta_empresa}</p>
                        </div>
                    ` : ''}

                    <!-- Acciones -->
                    <div class="flex gap-3">
                        ${!resena.respuesta_empresa ? `
                            <button 
                                onclick="abrirModalRespuesta(${resena.id})"
                                class="flex-1 bg-purple-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-purple-700 transition-all"
                            >
                                💬 Responder
                            </button>
                        ` : `
                            <button 
                                onclick="editarRespuesta(${resena.id})"
                                class="flex-1 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-all"
                            >
                                ✏️ Editar Respuesta
                            </button>
                        `}
                    </div>
                </div>
            `).join('');
        }

        // Filtrar reseñas
        function filtrarResenas(filtro) {
            filtroActual = filtro;
            
            // Actualizar botones
            document.querySelectorAll('[id^="btn-"]').forEach(btn => {
                btn.className = 'px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all';
            });
            
            if (filtro === 'todas') {
                document.getElementById('btn-todas').className = 'px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all';
                mostrarResenas(todasLasResenas);
            } else if (filtro === 'pendientes') {
                document.getElementById('btn-pendientes').className = 'px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all';
                const filtradas = todasLasResenas.filter(r => !r.respuesta_empresa);
                mostrarResenas(filtradas);
            } else {
                document.getElementById(`btn-${filtro}-estrellas`).className = 'px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all';
                const filtradas = todasLasResenas.filter(r => r.calificacion === filtro);
                mostrarResenas(filtradas);
            }
        }

        // Abrir modal de respuesta
        function abrirModalRespuesta(resenaId) {
            resenaActual = todasLasResenas.find(r => r.id === resenaId);
            if (!resenaActual) return;

            document.getElementById('resena-original').innerHTML = `
                <div class="flex items-start gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        ${(resenaActual.user?.name || 'U').charAt(0).toUpperCase()}
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">${resenaActual.user?.name || 'Usuario'}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            ${generarEstrellas(resenaActual.calificacion)}
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mt-2">${resenaActual.comentario || '<em class="text-gray-400">Sin comentario</em>'}</p>
            `;

            // Si está editando, prellenar
            if (resenaActual.respuesta_empresa) {
                document.getElementById('textarea-respuesta').value = resenaActual.respuesta_empresa;
                document.getElementById('contador-caracteres').textContent = resenaActual.respuesta_empresa.length;
            } else {
                document.getElementById('textarea-respuesta').value = '';
                document.getElementById('contador-caracteres').textContent = '0';
            }

            document.getElementById('modal-respuesta').classList.remove('hidden');
        }

        // Alias para editar
        function editarRespuesta(resenaId) {
            abrirModalRespuesta(resenaId);
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal-respuesta').classList.add('hidden');
            resenaActual = null;
        }

        // Enviar respuesta
        document.getElementById('form-respuesta').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const respuesta = document.getElementById('textarea-respuesta').value.trim();
            
            if (!respuesta || respuesta.length < 10) {
                alert('⚠️ La respuesta debe tener al menos 10 caracteres');
                return;
            }

            try {
                const response = await fetch(`${API_URL}/resenas/${resenaActual.id}/responder`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: JSON.stringify({ respuesta })
                });

                const result = await response.json();
                
                if (result.success) {
                    alert('✅ Respuesta publicada exitosamente');
                    cerrarModal();
                    await cargarResenas();
                } else {
                    alert('❌ Error: ' + (result.message || 'No se pudo publicar la respuesta'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error de conexión. Intenta nuevamente.');
            }
        });

        // Utilidades
        function generarEstrellas(calificacion) {
            let html = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= calificacion) {
                    html += '<span class="star-filled">⭐</span>';
                } else {
                    html += '<span class="star-empty">☆</span>';
                }
            }
            return html;
        }

        function formatFecha(fecha) {
            const date = new Date(fecha);
            const ahora = new Date();
            const diff = ahora - date;
            const dias = Math.floor(diff / (1000 * 60 * 60 * 24));
            
            if (dias === 0) return 'hoy';
            if (dias === 1) return 'ayer';
            if (dias < 7) return `hace ${dias} días`;
            if (dias < 30) return `hace ${Math.floor(dias / 7)} semanas`;
            return date.toLocaleDateString('es-MX', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        function mostrarError(mensaje) {
            alert('❌ ' + mensaje);
        }
    </script>

</body>
</html>

