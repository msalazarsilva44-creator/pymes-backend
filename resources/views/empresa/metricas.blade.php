<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métricas y Analíticas - MERCAROF</title>
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
    
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%); }
        .main-bg { background-color: #f3f4f6; }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-md border-b-2 border-mercarof-cyan border-opacity-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="/dashboard/empresa" class="text-2xl font-bold text-mercarof-navy">MERCAROF</a>
                <a href="/dashboard/empresa" class="text-gray-600 hover:text-mercarof-cyan transition-colors font-medium">← Volver al Dashboard</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header con Filtros -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">📊 Métricas y Analíticas</h1>
                <p class="text-gray-600">Análisis detallado del desempeño de tu empresa</p>
            </div>
            
            <!-- Filtros y Acciones -->
            <div class="flex flex-wrap gap-3">
                <select id="filtro-periodo" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    <option value="7">Últimos 7 días</option>
                    <option value="30" selected>Últimos 30 días</option>
                    <option value="90">Últimos 3 meses</option>
                </select>
                <button onclick="exportarReporte()" class="px-6 py-2 gradient-bg text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                    📥 Exportar Reporte
                </button>
            </div>
        </div>

        <!-- Stats Cards con Tendencias -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Vistas -->
            <div class="bg-white rounded-lg shadow-md p-6 transition-all hover:shadow-xl">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">👁️ Vistas Totales</span>
                    <span id="tendencia-vistas" class="text-xs font-semibold px-2 py-1 rounded-full">
                        <!-- Se llena dinámicamente -->
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1" id="stat-vistas-periodo">-</p>
                <p class="text-xs text-gray-500" id="comparacion-vistas">Cargando...</p>
            </div>

            <!-- Clics -->
            <div class="bg-white rounded-lg shadow-md p-6 transition-all hover:shadow-xl">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">📞 Clics Totales</span>
                    <span id="tendencia-clics" class="text-xs font-semibold px-2 py-1 rounded-full">
                        <!-- Se llena dinámicamente -->
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1" id="stat-clics-periodo">-</p>
                <p class="text-xs text-gray-500" id="comparacion-clics">Cargando...</p>
            </div>

            <!-- Calificación -->
            <div class="bg-white rounded-lg shadow-md p-6 transition-all hover:shadow-xl">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">⭐ Calificación</span>
                    <span id="tendencia-rating" class="text-xs font-semibold px-2 py-1 rounded-full">
                        <!-- Se llena dinámicamente -->
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1" id="stat-rating-periodo">-</p>
                <p class="text-xs text-gray-500" id="comparacion-rating">Basado en <span id="total-resenas">0</span> reseñas</p>
            </div>

            <!-- Tasa de Conversión -->
            <div class="bg-white rounded-lg shadow-md p-6 transition-all hover:shadow-xl">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-600 text-sm font-medium">💰 Conversión</span>
                    <span id="tendencia-conversion" class="text-xs font-semibold px-2 py-1 rounded-full">
                        <!-- Se llena dinámicamente -->
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1" id="stat-conversion">-%</p>
                <p class="text-xs text-gray-500" id="formula-conversion">clics / vistas</p>
            </div>
        </div>

        <!-- Gráfico Principal: Vistas y Clics -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">📈 Evolución de Vistas y Clics</h2>
            <div class="h-80 relative">
                <canvas id="chart-vistas-clics"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Tipos de Clics (Breakdown) -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">📱 Tipos de Interacción</h2>
                <div class="space-y-5" id="breakdown-clics">
                    <!-- Se llena dinámicamente -->
                    <div class="text-center py-8 text-gray-400">
                        Cargando datos...
                    </div>
                </div>
            </div>

            <!-- Gráfico de Donut: Distribución de Clics -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">🎯 Distribución de Clics</h2>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="chart-donut-clics"></canvas>
                </div>
            </div>
        </div>

        <!-- Tráfico por Día de Semana -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">🗓️ Tráfico por Día de la Semana</h2>
            <div class="h-64">
                <canvas id="chart-dias-semana"></canvas>
            </div>
        </div>

        <!-- Sección de Reseñas -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">💬 Gestión de Reseñas</h2>
                <a href="/empresa/resenas" class="px-4 py-2 gradient-bg text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                    Ver Todas las Reseñas →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-mercarof-cyan bg-opacity-10 rounded-lg p-4 border-l-4 border-mercarof-cyan">
                    <p class="text-sm text-gray-600 mb-1">Reseñas Totales</p>
                    <p class="text-2xl font-bold text-gray-900" id="resenas-total">0</p>
                </div>
                <div class="bg-orange-50 rounded-lg p-4 border-l-4 border-orange-500">
                    <p class="text-sm text-gray-600 mb-1">Sin Responder</p>
                    <p class="text-2xl font-bold text-orange-600" id="resenas-pendientes">0</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                    <p class="text-sm text-gray-600 mb-1">Tasa de Respuesta</p>
                    <p class="text-2xl font-bold text-green-600" id="resenas-tasa">0%</p>
                </div>
            </div>
        </div>

        <!-- Sugerencias Inteligentes -->
        <div class="bg-white rounded-lg shadow-md p-6 border-2 border-mercarof-cyan border-opacity-20 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">💡 Sugerencias Basadas en tus Datos</h2>
            <div class="space-y-3" id="sugerencias-container">
                <div class="flex items-start gap-3 p-4 bg-mercarof-cyan bg-opacity-5 rounded-lg border-l-4 border-mercarof-cyan">
                    <span class="text-2xl">📊</span>
                    <p class="text-sm text-gray-700">Analizando tus métricas para darte recomendaciones personalizadas...</p>
                </div>
            </div>
        </div>

        <!-- Tabla de Métricas Detalladas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">📋 Detalle de Métricas por Fecha</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vistas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clics Tel.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clics WA</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clics Web</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversión</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tabla-metricas">
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Cargando datos...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let empresaData = null;
        let authToken = null;
        let metricasData = null;
        let chartVistasClics = null;
        let chartDonut = null;
        let chartDiasSemana = null;

        // Inicializar
        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const userRole = localStorage.getItem('user_role');

            if (!authToken || userRole !== 'empresa' || !empresaData.id) {
                window.location.href = '/login';
                return;
            }

            await cargarMetricas();
            await cargarStatsResenas();
        });

        // Cargar métricas desde API
        async function cargarMetricas() {
            const periodo = document.getElementById('filtro-periodo').value;
            const fechaFin = new Date();
            const fechaInicio = new Date();
            fechaInicio.setDate(fechaInicio.getDate() - parseInt(periodo));

            try {
                const response = await fetch(
                    `${API_URL}/empresas/${empresaData.id}/metricas?fecha_inicio=${fechaInicio.toISOString().split('T')[0]}&fecha_fin=${fechaFin.toISOString().split('T')[0]}`, 
                    {
                        headers: { 'Authorization': `Bearer ${authToken}` }
                    }
                );

                const result = await response.json();
                
                if (result.success) {
                    metricasData = result.data;
                    actualizarDashboard(result.data);
                    inicializarGraficos(result.data);
                } else {
                    mostrarError('No se pudieron cargar las métricas');
                }
            } catch (error) {
                console.error('Error cargando métricas:', error);
                mostrarError('Error de conexión al cargar métricas');
            }
        }

        // Actualizar UI con datos
        function actualizarDashboard(data) {
            // Calcular totales del período
            const totalVistas = data.resumen.periodo.vistas || 0;
            const totalClicsTel = data.resumen.periodo.clics_telefono || 0;
            const totalClicsWA = data.resumen.periodo.clics_whatsapp || 0;
            const totalClicsWeb = data.resumen.periodo.clics_sitio_web || 0;
            const totalClics = totalClicsTel + totalClicsWA + totalClicsWeb;

            // Actualizar stats cards
            document.getElementById('stat-vistas-periodo').textContent = formatNumber(totalVistas);
            document.getElementById('stat-clics-periodo').textContent = formatNumber(totalClics);
            // Convertir a número antes de usar toFixed
            const calificacion = parseFloat(data.resumen.calificacion_promedio) || 0;
            document.getElementById('stat-rating-periodo').textContent = calificacion.toFixed(1);
            document.getElementById('total-resenas').textContent = data.resumen.resenas_totales || 0;

            // Calcular conversión
            const conversion = totalVistas > 0 
                ? ((totalClics / totalVistas) * 100).toFixed(1)
                : 0;
            document.getElementById('stat-conversion').textContent = conversion + '%';
            document.getElementById('formula-conversion').textContent = `${totalClics} clics / ${totalVistas} vistas`;

            // Actualizar comparaciones (simuladas por ahora)
            actualizarTendencias(totalVistas, totalClics, conversion);

            // Actualizar breakdown de clics
            actualizarBreakdownClics(totalClicsTel, totalClicsWA, totalClicsWeb, totalClics);

            // Generar sugerencias
            generarSugerencias(data);

            // Llenar tabla de métricas
            llenarTablaMetricas(data.metricas || []);
        }

        // Actualizar indicadores de tendencia
        function actualizarTendencias(vistas, clics, conversion) {
            // Simulación de tendencias (en producción, calcular vs período anterior)
            const tendenciaVistas = Math.random() > 0.5 ? 'up' : 'down';
            const porcentajeVistas = (Math.random() * 20).toFixed(0);
            
            const elementVistas = document.getElementById('tendencia-vistas');
            if (tendenciaVistas === 'up') {
                elementVistas.className = 'text-xs font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-full';
                elementVistas.textContent = `↗️ +${porcentajeVistas}%`;
            } else {
                elementVistas.className = 'text-xs font-semibold px-2 py-1 bg-red-100 text-red-700 rounded-full';
                elementVistas.textContent = `↘️ -${porcentajeVistas}%`;
            }

            // Similar para clics
            const tendenciaClics = Math.random() > 0.5 ? 'up' : 'down';
            const porcentajeClics = (Math.random() * 20).toFixed(0);
            
            const elementClics = document.getElementById('tendencia-clics');
            if (tendenciaClics === 'up') {
                elementClics.className = 'text-xs font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-full';
                elementClics.textContent = `↗️ +${porcentajeClics}%`;
            } else {
                elementClics.className = 'text-xs font-semibold px-2 py-1 bg-red-100 text-red-700 rounded-full';
                elementClics.textContent = `↘️ -${porcentajeClics}%`;
            }

            // Rating
            const elementRating = document.getElementById('tendencia-rating');
            elementRating.className = 'text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-700 rounded-full';
            elementRating.textContent = '⭐ Estable';

            // Conversión
            const elementConversion = document.getElementById('tendencia-conversion');
            const conversionNum = parseFloat(conversion);
            if (conversionNum >= 30) {
                elementConversion.className = 'text-xs font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-full';
                elementConversion.textContent = '✅ Excelente';
            } else if (conversionNum >= 15) {
                elementConversion.className = 'text-xs font-semibold px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full';
                elementConversion.textContent = '➡️ Bueno';
            } else {
                elementConversion.className = 'text-xs font-semibold px-2 py-1 bg-orange-100 text-orange-700 rounded-full';
                elementConversion.textContent = '⚠️ Mejorable';
            }
        }

        // Actualizar breakdown de clics
        function actualizarBreakdownClics(tel, wa, web, total) {
            const container = document.getElementById('breakdown-clics');
            
            if (total === 0) {
                container.innerHTML = '<div class="text-center py-8 text-gray-400">No hay clics en este período</div>';
                return;
            }

            const porcentajeTel = ((tel / total) * 100).toFixed(0);
            const porcentajeWA = ((wa / total) * 100).toFixed(0);
            const porcentajeWeb = ((web / total) * 100).toFixed(0);

            container.innerHTML = `
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">📞 Clic Teléfono</span>
                        <span class="text-sm font-bold text-gray-900">${tel} (${porcentajeTel}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: ${porcentajeTel}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">💬 Clic WhatsApp</span>
                        <span class="text-sm font-bold text-gray-900">${wa} (${porcentajeWA}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: ${porcentajeWA}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">🌐 Clic Sitio Web</span>
                        <span class="text-sm font-bold text-gray-900">${web} (${porcentajeWeb}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-mercarof-navy h-3 rounded-full transition-all duration-500" style="width: ${porcentajeWeb}%"></div>
                    </div>
                </div>
            `;
        }

        // Inicializar gráficos
        function inicializarGraficos(data) {
            // Procesar datos para gráficos
            const metricas = data.metricas || [];
            
            // Agrupar por fecha
            const metricasPorFecha = {};
            metricas.forEach(m => {
                const fecha = m.fecha;
                if (!metricasPorFecha[fecha]) {
                    metricasPorFecha[fecha] = {
                        vistas: 0,
                        clics_telefono: 0,
                        clics_whatsapp: 0,
                        clics_sitio_web: 0
                    };
                }
                metricasPorFecha[fecha][m.tipo] = parseInt(m.total);
            });

            // Convertir a arrays para Chart.js
            const fechas = Object.keys(metricasPorFecha).sort();
            const vistas = fechas.map(f => metricasPorFecha[f].vistas || 0);
            const clics = fechas.map(f => 
                (metricasPorFecha[f].clics_telefono || 0) + 
                (metricasPorFecha[f].clics_whatsapp || 0) + 
                (metricasPorFecha[f].clics_sitio_web || 0)
            );

            // Gráfico de Vistas y Clics
            const ctx1 = document.getElementById('chart-vistas-clics');
            if (chartVistasClics) chartVistasClics.destroy();
            
            chartVistasClics = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: fechas.map(formatDate),
                    datasets: [{
                        label: 'Vistas',
                        data: vistas,
                        borderColor: 'rgb(102, 126, 234)',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Clics',
                        data: clics,
                        borderColor: 'rgb(118, 75, 162)',
                        backgroundColor: 'rgba(118, 75, 162, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de Donut (distribución de clics)
            const totalClicsTel = data.resumen.periodo.clics_telefono || 0;
            const totalClicsWA = data.resumen.periodo.clics_whatsapp || 0;
            const totalClicsWeb = data.resumen.periodo.clics_sitio_web || 0;

            const ctx2 = document.getElementById('chart-donut-clics');
            if (chartDonut) chartDonut.destroy();

            chartDonut = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Teléfono', 'WhatsApp', 'Sitio Web'],
                    datasets: [{
                        data: [totalClicsTel, totalClicsWA, totalClicsWeb],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(168, 85, 247, 0.8)'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Gráfico de días de semana (simulado)
            const ctx3 = document.getElementById('chart-dias-semana');
            if (chartDiasSemana) chartDiasSemana.destroy();

            chartDiasSemana = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                    datasets: [{
                        label: 'Visitas',
                        data: generarDatosSemanales(vistas),
                        backgroundColor: 'rgba(102, 126, 234, 0.8)',
                        borderColor: 'rgb(102, 126, 234)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Generar datos semanales (simulados)
        function generarDatosSemanales(vistas) {
            const total = vistas.reduce((a, b) => a + b, 0);
            const promedio = total / 7;
            return Array(7).fill(0).map(() => Math.floor(promedio * (0.7 + Math.random() * 0.6)));
        }

        // Generar sugerencias inteligentes
        function generarSugerencias(data) {
            const container = document.getElementById('sugerencias-container');
            const sugerencias = [];

            const totalVistas = data.resumen.periodo.vistas || 0;
            const totalClics = (data.resumen.periodo.clics_telefono || 0) + 
                              (data.resumen.periodo.clics_whatsapp || 0) + 
                              (data.resumen.periodo.clics_sitio_web || 0);
            const conversion = totalVistas > 0 ? (totalClics / totalVistas) * 100 : 0;

            // Convertir calificación a número para comparaciones
            const calificacionPromedio = parseFloat(data.resumen.calificacion_promedio) || 0;
            
            // Analizar y generar sugerencias
            if (totalVistas > 50 && conversion < 15) {
                sugerencias.push({
                    icon: '⚠️',
                    text: 'Tienes muchas vistas pero baja conversión. Considera mejorar tu descripción, agregar más fotos de calidad y actualizar tus servicios.',
                    type: 'warning'
                });
            }

            if (data.resumen.periodo.clics_whatsapp > data.resumen.periodo.clics_telefono * 2) {
                sugerencias.push({
                    icon: '💬',
                    text: 'WhatsApp es tu canal más popular. Asegúrate de tener configurada la respuesta automática y responde rápidamente para no perder clientes.',
                    type: 'success'
                });
            }

            if (calificacionPromedio < 4.0 && data.resumen.resenas_totales > 5) {
                sugerencias.push({
                    icon: '⭐',
                    text: 'Tu calificación está por debajo de 4.0 estrellas. Responde profesionalmente a las reseñas negativas y trabaja en mejorar la calidad de tu servicio.',
                    type: 'error'
                });
            } else if (calificacionPromedio >= 4.5) {
                sugerencias.push({
                    icon: '🎉',
                    text: '¡Excelente! Tu calificación es muy alta. Sigue brindando ese excelente servicio y pide a tus clientes satisfechos que dejen reseñas.',
                    type: 'success'
                });
            }

            if (totalVistas < 20) {
                sugerencias.push({
                    icon: '📈',
                    text: 'Pocas vistas en tu perfil. Considera mejorar tu plan a Básico o Premium para aparecer en mejores posiciones y obtener más visibilidad.',
                    type: 'info'
                });
            }

            if (conversion >= 30) {
                sugerencias.push({
                    icon: '💰',
                    text: '¡Tu tasa de conversión es excelente! Más del 30% de visitantes interactúan con tu empresa. Sigue así y considera expandir tus servicios.',
                    type: 'success'
                });
            }

            if (sugerencias.length === 0) {
                sugerencias.push({
                    icon: '👍',
                    text: 'Tu empresa está funcionando bien. Sigue actualizando tu perfil y respondiendo a tus clientes para mantener el buen desempeño.',
                    type: 'info'
                });
            }

            // Renderizar sugerencias
            container.innerHTML = sugerencias.map(s => `
                <div class="flex items-start gap-3 p-4 bg-white rounded-lg border-l-4 ${
                    s.type === 'success' ? 'border-green-500' :
                    s.type === 'warning' ? 'border-yellow-500' :
                    s.type === 'error' ? 'border-red-500' :
                    'border-mercarof-cyan'
                }">
                    <span class="text-2xl flex-shrink-0">${s.icon}</span>
                    <p class="text-sm text-gray-700">${s.text}</p>
                </div>
            `).join('');
        }

        // Llenar tabla de métricas
        function llenarTablaMetricas(metricas) {
            const tbody = document.getElementById('tabla-metricas');
            
            if (metricas.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No hay datos de métricas en este período
                        </td>
                    </tr>
                `;
                return;
            }

            // Agrupar por fecha
            const metricasPorFecha = {};
            metricas.forEach(m => {
                const fecha = m.fecha;
                if (!metricasPorFecha[fecha]) {
                    metricasPorFecha[fecha] = {
                        vista: 0,
                        clic_telefono: 0,
                        clic_whatsapp: 0,
                        clic_sitio_web: 0
                    };
                }
                metricasPorFecha[fecha][m.tipo] = parseInt(m.total);
            });

            // Ordenar por fecha descendente
            const fechasOrdenadas = Object.keys(metricasPorFecha).sort().reverse();

            tbody.innerHTML = fechasOrdenadas.map(fecha => {
                const m = metricasPorFecha[fecha];
                const vistas = m.vista || 0;
                const clicsTel = m.clic_telefono || 0;
                const clicsWA = m.clic_whatsapp || 0;
                const clicsWeb = m.clic_sitio_web || 0;
                const totalClics = clicsTel + clicsWA + clicsWeb;
                const conversion = vistas > 0 ? ((totalClics / vistas) * 100).toFixed(1) : 0;

                return `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${formatDate(fecha)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            ${vistas}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            ${clicsTel}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            ${clicsWA}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            ${clicsWeb}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${
                            conversion >= 30 ? 'text-green-600' : 
                            conversion >= 15 ? 'text-yellow-600' : 
                            'text-gray-600'
                        }">
                            ${conversion}%
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Exportar reporte
        async function exportarReporte() {
            alert('🚧 Función en desarrollo\n\nPróximamente podrás exportar tus métricas en formato PDF o Excel.');
            
            // TODO: Implementar exportación con jsPDF o backend endpoint
            // const { jsPDF } = window.jspdf;
            // const doc = new jsPDF();
            // doc.text('Reporte de Métricas - MERCAROF', 10, 10);
            // doc.save('reporte-metricas.pdf');
        }

        // Cargar stats de reseñas
        async function cargarStatsResenas() {
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaData.id}/resenas`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });

                const result = await response.json();
                
                if (result.success) {
                    const resenas = result.data.data || result.data || [];
                    const total = resenas.length;
                    const pendientes = resenas.filter(r => !r.respuesta_empresa).length;
                    const respondidas = total - pendientes;
                    const tasa = total > 0 ? ((respondidas / total) * 100).toFixed(0) : 0;

                    document.getElementById('resenas-total').textContent = total;
                    document.getElementById('resenas-pendientes').textContent = pendientes;
                    document.getElementById('resenas-tasa').textContent = tasa + '%';
                }
            } catch (error) {
                console.error('Error cargando stats de reseñas:', error);
            }
        }

        // Cambio de filtro
        document.getElementById('filtro-periodo').addEventListener('change', cargarMetricas);

        // Utilidades
        function formatNumber(num) {
            return new Intl.NumberFormat('es-MX').format(num);
        }

        function formatDate(dateString) {
            const date = new Date(dateString + 'T00:00:00');
            return date.toLocaleDateString('es-MX', { 
                day: '2-digit', 
                month: 'short'
            });
        }

        function mostrarError(mensaje) {
            alert('❌ ' + mensaje);
        }
    </script>

</body>
</html>

