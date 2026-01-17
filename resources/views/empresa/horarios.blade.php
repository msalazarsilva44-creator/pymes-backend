<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios - ServiLocal Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .main-bg {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-md border-b-2 border-purple-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="/dashboard/empresa" class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">ServiLocal</a>
                <a href="/dashboard/empresa" class="text-gray-600 hover:text-purple-600 transition-colors font-medium">← Volver al Dashboard</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🕐 Horarios de Atención</h1>
            <p class="text-gray-600">Configura tus horarios para que los clientes sepan cuándo estás disponible</p>
        </div>

        <!-- Mensajes -->
        <div id="mensaje" class="hidden mb-6 p-4 rounded-lg"></div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
            <div class="flex gap-3 flex-wrap">
                <button onclick="aplicarATodos()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm font-medium">
                    📋 Aplicar mismo horario a todos
                </button>
                <button onclick="marcarLunesViernes()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all text-sm font-medium">
                    💼 Lunes a Viernes (8:00-18:00)
                </button>
                <button onclick="cerrarTodos()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all text-sm font-medium">
                    🚫 Cerrar todos
                </button>
            </div>
        </div>

        <!-- Horarios por Día -->
        <div class="space-y-4">
            
            <!-- Lunes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="activo-lunes" class="w-5 h-5 text-purple-600 rounded" onchange="toggleDia('lunes')">
                        <label for="activo-lunes" class="text-lg font-semibold text-gray-900">Lunes</label>
                    </div>
                    <span id="status-lunes" class="text-sm text-red-600 font-medium">Cerrado</span>
                </div>
                <div id="horarios-lunes" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Apertura</label>
                        <input type="time" id="apertura-lunes" value="08:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Cierre</label>
                        <input type="time" id="cierre-lunes" value="18:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Martes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="activo-martes" class="w-5 h-5 text-purple-600 rounded" onchange="toggleDia('martes')">
                        <label for="activo-martes" class="text-lg font-semibold text-gray-900">Martes</label>
                    </div>
                    <span id="status-martes" class="text-sm text-red-600 font-medium">Cerrado</span>
                </div>
                <div id="horarios-martes" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Apertura</label>
                        <input type="time" id="apertura-martes" value="08:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Cierre</label>
                        <input type="time" id="cierre-martes" value="18:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Miércoles -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="activo-miercoles" class="w-5 h-5 text-purple-600 rounded" onchange="toggleDia('miercoles')">
                        <label for="activo-miercoles" class="text-lg font-semibold text-gray-900">Miércoles</label>
                    </div>
                    <span id="status-miercoles" class="text-sm text-red-600 font-medium">Cerrado</span>
                </div>
                <div id="horarios-miercoles" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Apertura</label>
                        <input type="time" id="apertura-miercoles" value="08:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Cierre</label>
                        <input type="time" id="cierre-miercoles" value="18:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Jueves -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="activo-jueves" class="w-5 h-5 text-purple-600 rounded" onchange="toggleDia('jueves')">
                        <label for="activo-jueves" class="text-lg font-semibold text-gray-900">Jueves</label>
                    </div>
                    <span id="status-jueves" class="text-sm text-red-600 font-medium">Cerrado</span>
                </div>
                <div id="horarios-jueves" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Apertura</label>
                        <input type="time" id="apertura-jueves" value="08:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Cierre</label>
                        <input type="time" id="cierre-jueves" value="18:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Viernes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="activo-viernes" class="w-5 h-5 text-purple-600 rounded" onchange="toggleDia('viernes')">
                        <label for="activo-viernes" class="text-lg font-semibold text-gray-900">Viernes</label>
                    </div>
                    <span id="status-viernes" class="text-sm text-red-600 font-medium">Cerrado</span>
                </div>
                <div id="horarios-viernes" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Apertura</label>
                        <input type="time" id="apertura-viernes" value="08:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Cierre</label>
                        <input type="time" id="cierre-viernes" value="18:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Sábado -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="activo-sabado" class="w-5 h-5 text-purple-600 rounded" onchange="toggleDia('sabado')">
                        <label for="activo-sabado" class="text-lg font-semibold text-gray-900">Sábado</label>
                    </div>
                    <span id="status-sabado" class="text-sm text-red-600 font-medium">Cerrado</span>
                </div>
                <div id="horarios-sabado" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Apertura</label>
                        <input type="time" id="apertura-sabado" value="08:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Cierre</label>
                        <input type="time" id="cierre-sabado" value="14:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Domingo -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="activo-domingo" class="w-5 h-5 text-purple-600 rounded" onchange="toggleDia('domingo')">
                        <label for="activo-domingo" class="text-lg font-semibold text-gray-900">Domingo</label>
                    </div>
                    <span id="status-domingo" class="text-sm text-red-600 font-medium">Cerrado</span>
                </div>
                <div id="horarios-domingo" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Apertura</label>
                        <input type="time" id="apertura-domingo" value="08:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Cierre</label>
                        <input type="time" id="cierre-domingo" value="14:00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-8">
            <button 
                onclick="guardarHorarios()"
                class="flex-1 gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all"
            >
                💾 Guardar Horarios
            </button>
            <a 
                href="/dashboard/empresa"
                class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all"
            >
                Cancelar
            </a>
        </div>

    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = '';
        let empresaId = null;

        const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const userRole = localStorage.getItem('user_role');

            if (!authToken || userRole !== 'empresa') {
                window.location.href = '/login';
                return;
            }

            empresaId = empresaData.id;
            
            // Cargar horarios existentes
            await cargarHorarios();
        });

        // Toggle día
        function toggleDia(dia) {
            const activo = document.getElementById(`activo-${dia}`).checked;
            const horariosDiv = document.getElementById(`horarios-${dia}`);
            const status = document.getElementById(`status-${dia}`);

            if (activo) {
                horariosDiv.classList.remove('hidden');
                status.textContent = 'Abierto';
                status.classList.remove('text-red-600');
                status.classList.add('text-green-600');
            } else {
                horariosDiv.classList.add('hidden');
                status.textContent = 'Cerrado';
                status.classList.remove('text-green-600');
                status.classList.add('text-red-600');
            }
        }

        // Aplicar mismo horario a todos
        function aplicarATodos() {
            const apertura = prompt('Hora de apertura (HH:MM):', '08:00');
            const cierre = prompt('Hora de cierre (HH:MM):', '18:00');

            if (apertura && cierre) {
                dias.forEach(dia => {
                    document.getElementById(`activo-${dia}`).checked = true;
                    document.getElementById(`apertura-${dia}`).value = apertura;
                    document.getElementById(`cierre-${dia}`).value = cierre;
                    toggleDia(dia);
                });
                mostrarMensaje('✅ Horarios aplicados a todos los días', 'success');
            }
        }

        // Lunes a Viernes 8-18
        function marcarLunesViernes() {
            ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'].forEach(dia => {
                document.getElementById(`activo-${dia}`).checked = true;
                document.getElementById(`apertura-${dia}`).value = '08:00';
                document.getElementById(`cierre-${dia}`).value = '18:00';
                toggleDia(dia);
            });
            mostrarMensaje('✅ Horario de Lunes a Viernes configurado', 'success');
        }

        // Cerrar todos
        function cerrarTodos() {
            dias.forEach(dia => {
                document.getElementById(`activo-${dia}`).checked = false;
                toggleDia(dia);
            });
            mostrarMensaje('ℹ️ Todos los días marcados como cerrados', 'info');
        }

        // Cargar horarios
        async function cargarHorarios() {
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/horarios`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    }
                });

                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    result.data.forEach(horario => {
                        const dia = horario.dia_semana.toLowerCase();
                        if (dias.includes(dia)) {
                            document.getElementById(`activo-${dia}`).checked = true;
                            document.getElementById(`apertura-${dia}`).value = horario.hora_apertura;
                            document.getElementById(`cierre-${dia}`).value = horario.hora_cierre;
                            toggleDia(dia);
                        }
                    });
                }
            } catch (error) {
                console.error('Error cargando horarios:', error);
            }
        }

        // Guardar horarios
        async function guardarHorarios() {
            const horarios = [];

            dias.forEach(dia => {
                const activo = document.getElementById(`activo-${dia}`).checked;
                if (activo) {
                    horarios.push({
                        dia_semana: dia.charAt(0).toUpperCase() + dia.slice(1),
                        hora_apertura: document.getElementById(`apertura-${dia}`).value,
                        hora_cierre: document.getElementById(`cierre-${dia}`).value
                    });
                }
            });

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/horarios`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: JSON.stringify({ horarios })
                });

                const result = await response.json();

                if (result.success) {
                    mostrarMensaje('✅ ¡Horarios guardados exitosamente!', 'success');
                    setTimeout(() => {
                        window.location.href = '/dashboard/empresa';
                    }, 2000);
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al guardar los horarios'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        }

        // Mostrar mensajes
        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            let bgClass = 'bg-blue-100 text-blue-800 border-blue-200';
            
            if (tipo === 'success') bgClass = 'bg-green-100 text-green-800 border-green-200';
            if (tipo === 'error') bgClass = 'bg-red-100 text-red-800 border-red-200';
            
            mensaje.className = `mb-6 p-4 rounded-lg border ${bgClass}`;
            mensaje.textContent = texto;
            mensaje.classList.remove('hidden');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                mensaje.classList.add('hidden');
            }, 5000);
        }
    </script>

</body>
</html>

