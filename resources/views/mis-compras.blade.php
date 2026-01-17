<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Compras - ServiLocal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * {
            font-family: 'Inter', sans-serif;
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
                <a href="/dashboard/cliente" class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">ServiLocal</a>
                <a href="/dashboard/cliente" class="text-gray-600 hover:text-purple-600 transition-colors font-medium">← Volver al inicio</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🛍️ Mis Compras</h1>
            <p class="text-gray-600">Historial de servicios contratados y contactos realizados</p>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex">
                    <button onclick="cambiarTab('contactos')" class="tab-btn px-6 py-4 font-medium border-b-2 border-purple-600 text-purple-600" data-tab="contactos">
                        📞 Contactos Realizados
                    </button>
                    <button onclick="cambiarTab('historial')" class="tab-btn px-6 py-4 font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900" data-tab="historial">
                        📋 Historial Completo
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contactos Realizados -->
        <div id="tab-contactos" class="tab-content">
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="text-6xl mb-4">📱</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No has contactado empresas aún</h3>
                <p class="text-gray-600 mb-6">Cuando contactes una empresa, aparecerá aquí para tu seguimiento</p>
                <a href="/dashboard/cliente" class="inline-block bg-purple-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-purple-700 transition-all">
                    Buscar Servicios
                </a>
            </div>
        </div>

        <!-- Historial Completo -->
        <div id="tab-historial" class="tab-content hidden">
            <div class="space-y-4">
                
                <!-- Ejemplo de entrada de historial -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-2xl">
                                🔍
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Búsqueda realizada</h3>
                                <p class="text-sm text-gray-600">Servicios de plomería</p>
                                <p class="text-xs text-gray-500 mt-1">Hace 2 horas</p>
                            </div>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Búsqueda
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-2xl">
                                👁️
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Perfil visualizado</h3>
                                <p class="text-sm text-gray-600">Plomería Express S.A.</p>
                                <p class="text-xs text-gray-500 mt-1">Hace 3 horas</p>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Vista
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-2xl">
                                ❤️
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Agregado a favoritos</h3>
                                <p class="text-sm text-gray-600">Electricidad Pro</p>
                                <p class="text-xs text-gray-500 mt-1">Ayer</p>
                            </div>
                        </div>
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Favorito
                        </span>
                    </div>
                </div>

                <div class="text-center py-8">
                    <p class="text-gray-500 text-sm">Este es tu historial de actividad (demo)</p>
                </div>

            </div>
        </div>

    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = '';

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');

            if (!authToken) {
                window.location.href = '/login';
                return;
            }

            // Cargar historial (por ahora mock)
        });

        function cambiarTab(tab) {
            // Ocultar todos los tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            
            // Remover activo de botones
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-purple-600', 'text-purple-600');
                btn.classList.add('border-transparent', 'text-gray-600');
            });

            // Mostrar tab seleccionado
            document.getElementById(`tab-${tab}`).classList.remove('hidden');
            
            // Activar botón
            const btnActivo = document.querySelector(`[data-tab="${tab}"]`);
            if (btnActivo) {
                btnActivo.classList.remove('border-transparent', 'text-gray-600');
                btnActivo.classList.add('border-purple-600', 'text-purple-600');
            }
        }
    </script>

</body>
</html>

