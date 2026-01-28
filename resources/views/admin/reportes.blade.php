<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ejecutivo - MERCAROF</title>
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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%);
        }
        .main-bg {
            background-color: #f3f4f6;
        }
        
        .kpi-card {
            transition: all 0.3s ease;
        }
        
        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .trend-up {
            color: #10b981;
        }
        
        .trend-down {
            color: #ef4444;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            .main-bg {
                background-color: white;
            }
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="gradient-bg shadow-lg no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <a href="/dashboard/admin" class="text-white hover:text-gray-200">
                        ← Volver
                    </a>
                    <span class="text-white">|</span>
                    <h1 class="text-2xl font-bold text-white">
                        📊 Dashboard Ejecutivo
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="exportarPDF()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-semibold px-4 py-2 rounded-lg transition-all border border-white border-opacity-30">
                        📄 Exportar PDF
                    </button>
                    <button onclick="cerrarSesion()" class="bg-white text-mercarof-navy hover:bg-gray-100 font-semibold px-4 py-2 rounded-lg transition-all">
                        Cerrar Sesión
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Filtros de Período -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 no-print">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Filtrar Período</h2>
                    <p class="text-sm text-gray-600">Selecciona el rango de fechas para el análisis</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input 
                            type="date" 
                            id="fecha-inicio"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input 
                            type="date" 
                            id="fecha-fin"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan"
                        >
                    </div>
                    <div class="flex items-end">
                        <button onclick="aplicarFiltros()" class="gradient-bg text-white font-semibold px-6 py-2 rounded-lg hover:shadow-lg transition-all">
                            Aplicar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas Críticas -->
        <div id="alertas-container" class="mb-8">
            <!-- Se llenará dinámicamente -->
        </div>

        <!-- KPIs Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- KPI: MRR -->
            <div class="kpi-card bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">MRR (Ingresos Mensuales)</h3>
                    <span class="text-2xl">💰</span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">$<span id="kpi-mrr">0</span></p>
                <p class="text-sm text-gray-600">Ingresos recurrentes mensuales</p>
            </div>

            <!-- KPI: Empresas Activas -->
            <div class="kpi-card bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Empresas Activas</h3>
                    <span class="text-2xl">🏢</span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1" id="kpi-empresas-activas">0</p>
                <p class="text-sm" id="trend-empresas">
                    <span class="font-semibold">--</span> vs período anterior
                </p>
            </div>

            <!-- KPI: Tasa de Conversión -->
            <div class="kpi-card bg-white rounded-lg shadow-md p-6 border-l-4 border-mercarof-cyan">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Tasa de Conversión</h3>
                    <span class="text-2xl">🎯</span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1"><span id="kpi-conversion">0</span>%</p>
                <p class="text-sm text-gray-600">Empresas con plan pago</p>
            </div>

            <!-- KPI: Ingresos del Período -->
            <div class="kpi-card bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Ingresos del Período</h3>
                    <span class="text-2xl">💵</span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">$<span id="kpi-ingresos-periodo">0</span></p>
                <p class="text-sm" id="trend-ingresos">
                    <span class="font-semibold">--</span> vs período anterior
                </p>
            </div>

        </div>

        <!-- KPIs Secundarios -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Nuevas Empresas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Nuevas Empresas</h3>
                    <span class="text-2xl">🆕</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-1" id="kpi-nuevas-empresas">0</p>
                <p class="text-sm" id="trend-nuevas-empresas">
                    <span class="font-semibold">--</span> vs período anterior
                </p>
            </div>

            <!-- Nuevos Clientes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Nuevos Clientes</h3>
                    <span class="text-2xl">👥</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 mb-1" id="kpi-nuevos-clientes">0</p>
                <p class="text-sm" id="trend-nuevos-clientes">
                    <span class="font-semibold">--</span> vs período anterior
                </p>
            </div>

            <!-- Vistas del Marketplace -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Vistas del Período</h3>
                    <span class="text-2xl">👁️</span>
                </div>
                <p class="text-2xl font-bold text-gray-900" id="kpi-vistas">0</p>
            </div>

            <!-- Tasa de Interacción -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Tasa de Interacción</h3>
                    <span class="text-2xl">📈</span>
                </div>
                <p class="text-2xl font-bold text-gray-900"><span id="kpi-interaccion">0</span>%</p>
                <p class="text-sm text-gray-600"><span id="kpi-clics">0</span> clics</p>
            </div>

        </div>

        <!-- Gráficos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            <!-- Gráfico: Evolución de Ingresos -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Evolución de Ingresos (Últimos 12 Meses)</h3>
                <div class="chart-container">
                    <canvas id="chart-ingresos"></canvas>
                </div>
            </div>

            <!-- Gráfico: Crecimiento de Empresas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📈 Nuevas Empresas por Mes</h3>
                <div class="chart-container">
                    <canvas id="chart-empresas"></canvas>
                </div>
            </div>

        </div>

        <!-- Distribución por Planes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Gráfico: Distribución de Planes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">🎯 Distribución por Planes</h3>
                <div class="chart-container">
                    <canvas id="chart-planes"></canvas>
                </div>
            </div>

            <!-- Resumen de Ingresos Totales -->
            <div class="bg-gradient-to-br from-mercarof-navy to-mercarof-cyan rounded-lg shadow-lg p-8 text-white">
                <h3 class="text-xl font-bold mb-4">💰 Resumen Financiero</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg">Ingresos Totales Acumulados:</span>
                        <span class="text-3xl font-bold">$<span id="ingresos-totales">0</span></span>
                    </div>
                    <div class="border-t border-white border-opacity-30 pt-4">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold" id="plan-gratis">0</div>
                                <div class="text-sm opacity-80">Gratis</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold" id="plan-basico">0</div>
                                <div class="text-sm opacity-80">Básico</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold" id="plan-premium">0</div>
                                <div class="text-sm opacity-80">Premium</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

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
        const userRole = localStorage.getItem('user_role');

        // Variables para los gráficos
        let chartIngresos, chartEmpresas, chartPlanes;

        // Verificar autenticación
        if (!authToken || userRole !== 'admin') {
            window.location.href = '/login';
        }

        // Configurar fechas por defecto (último mes)
        const hoy = new Date();
        const haceUnMes = new Date();
        haceUnMes.setMonth(haceUnMes.getMonth() - 1);
        
        document.getElementById('fecha-fin').valueAsDate = hoy;
        document.getElementById('fecha-inicio').valueAsDate = haceUnMes;

        // Cargar datos al iniciar
        document.addEventListener('DOMContentLoaded', () => {
            cargarReporte();
        });

        // Aplicar filtros
        function aplicarFiltros() {
            cargarReporte();
        }

        // Cargar reporte ejecutivo
        async function cargarReporte() {
            try {
                const fechaInicio = document.getElementById('fecha-inicio').value;
                const fechaFin = document.getElementById('fecha-fin').value;

                if (!fechaInicio || !fechaFin) {
                    notyf.error('Por favor selecciona ambas fechas');
                    return;
                }

                const response = await fetch(`${ADMIN_API_URL}/reportes/ejecutivo?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Error al cargar el reporte');
                }

                const data = await response.json();
                
                if (data.success) {
                    renderizarReporte(data.data);
                    notyf.success('✅ Reporte actualizado');
                }
                
            } catch (error) {
                console.error('Error:', error);
                notyf.error('❌ Error al cargar el reporte');
            }
        }

        // Renderizar reporte
        function renderizarReporte(data) {
            const kpis = data.kpis;

            // KPIs Principales
            document.getElementById('kpi-mrr').textContent = kpis.mrr.toLocaleString('es-MX', {minimumFractionDigits: 2});
            document.getElementById('kpi-empresas-activas').textContent = kpis.empresas_activas;
            document.getElementById('kpi-conversion').textContent = kpis.tasa_conversion;
            document.getElementById('kpi-ingresos-periodo').textContent = kpis.ingresos_periodo.toLocaleString('es-MX', {minimumFractionDigits: 2});

            // Tendencias
            actualizarTendencia('trend-empresas', kpis.crecimiento_empresas);
            actualizarTendencia('trend-ingresos', kpis.crecimiento_ingresos);
            actualizarTendencia('trend-nuevas-empresas', kpis.crecimiento_nuevas_empresas);
            actualizarTendencia('trend-nuevos-clientes', kpis.crecimiento_clientes);

            // KPIs Secundarios
            document.getElementById('kpi-nuevas-empresas').textContent = kpis.nuevas_empresas;
            document.getElementById('kpi-nuevos-clientes').textContent = kpis.nuevos_clientes;
            document.getElementById('kpi-vistas').textContent = kpis.vistas_periodo.toLocaleString();
            document.getElementById('kpi-clics').textContent = kpis.clics_periodo.toLocaleString();
            document.getElementById('kpi-interaccion').textContent = kpis.tasa_interaccion;

            // Resumen financiero
            document.getElementById('ingresos-totales').textContent = kpis.ingresos_totales.toLocaleString('es-MX', {minimumFractionDigits: 2});
            document.getElementById('plan-gratis').textContent = data.distribucion_planes.gratis;
            document.getElementById('plan-basico').textContent = data.distribucion_planes.basico;
            document.getElementById('plan-premium').textContent = data.distribucion_planes.premium;

            // Alertas
            renderizarAlertas(data.alertas);

            // Gráficos
            renderizarGraficoIngresos(data.evolucion_ingresos);
            renderizarGraficoEmpresas(data.evolucion_empresas);
            renderizarGraficoPlanes(data.distribucion_planes);
        }

        // Actualizar tendencia
        function actualizarTendencia(elementId, valor) {
            const elemento = document.getElementById(elementId);
            const icono = valor >= 0 ? '↗️' : '↘️';
            const clase = valor >= 0 ? 'trend-up' : 'trend-down';
            
            elemento.innerHTML = `<span class="font-semibold ${clase}">${icono} ${Math.abs(valor).toFixed(1)}%</span> vs período anterior`;
        }

        // Renderizar alertas
        function renderizarAlertas(alertas) {
            const container = document.getElementById('alertas-container');
            
            if (alertas.length === 0) {
                container.innerHTML = '';
                return;
            }

            const colores = {
                warning: 'bg-yellow-50 border-yellow-400 text-yellow-800',
                danger: 'bg-red-50 border-red-400 text-red-800',
                info: 'bg-blue-50 border-blue-400 text-blue-800'
            };

            container.innerHTML = alertas.map(alerta => `
                <div class="${colores[alerta.tipo]} border-l-4 p-4 rounded-lg mb-4">
                    <p class="font-semibold">${alerta.mensaje}</p>
                </div>
            `).join('');
        }

        // Gráfico de Ingresos
        function renderizarGraficoIngresos(datos) {
            const ctx = document.getElementById('chart-ingresos').getContext('2d');
            
            if (chartIngresos) {
                chartIngresos.destroy();
            }

            chartIngresos = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: datos.map(d => d.mes),
                    datasets: [{
                        label: 'Ingresos ($)',
                        data: datos.map(d => d.ingresos),
                        borderColor: 'rgb(102, 126, 234)',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4,
                        fill: true
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
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Gráfico de Empresas
        function renderizarGraficoEmpresas(datos) {
            const ctx = document.getElementById('chart-empresas').getContext('2d');
            
            if (chartEmpresas) {
                chartEmpresas.destroy();
            }

            chartEmpresas = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: datos.map(d => d.mes),
                    datasets: [{
                        label: 'Nuevas Empresas',
                        data: datos.map(d => d.empresas),
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: 'rgb(16, 185, 129)',
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
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Gráfico de Planes
        function renderizarGraficoPlanes(datos) {
            const ctx = document.getElementById('chart-planes').getContext('2d');
            
            if (chartPlanes) {
                chartPlanes.destroy();
            }

            chartPlanes = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Gratis', 'Básico', 'Premium'],
                    datasets: [{
                        data: [datos.gratis, datos.basico, datos.premium],
                        backgroundColor: [
                            'rgba(156, 163, 175, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(168, 85, 247, 0.8)'
                        ],
                        borderColor: [
                            'rgb(156, 163, 175)',
                            'rgb(59, 130, 246)',
                            'rgb(168, 85, 247)'
                        ],
                        borderWidth: 2
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
        }

        // Exportar a PDF
        function exportarPDF() {
            notyf.open({
                type: 'info',
                message: '📄 Preparando exportación...'
            });
            
            setTimeout(() => {
                window.print();
            }, 500);
        }

        // Cerrar sesión
        function cerrarSesion() {
            if (confirm('¿Seguro que deseas cerrar sesión?')) {
                localStorage.clear();
                window.location.href = '/login';
            }
        }
    </script>

</body>
</html>

