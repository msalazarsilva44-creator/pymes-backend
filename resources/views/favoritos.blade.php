<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Favoritos - ServiLocal</title>
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
            <h1 class="text-3xl font-bold text-gray-900 mb-2">❤️ Mis Favoritos</h1>
            <p class="text-gray-600">Empresas que has guardado para consultar más tarde</p>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex gap-4">
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option>Todas las categorías</option>
                <option>Construcción</option>
                <option>Plomería</option>
                <option>Electricidad</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option>Ordenar por: Recientes</option>
                <option>Mejor calificados</option>
                <option>Nombre A-Z</option>
            </select>
        </div>

        <!-- Lista de Favoritos -->
        <div id="lista-favoritos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Se llenarán dinámicamente -->
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <div class="text-6xl mb-4">💔</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No tienes favoritos aún</h3>
                    <p class="text-gray-600 mb-6">Empieza a guardar empresas que te interesen</p>
                    <a href="/dashboard/cliente" class="inline-block bg-purple-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-purple-700 transition-all">
                        Explorar Empresas
                    </a>
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

            // Cargar favoritos (por ahora mock)
            cargarFavoritos();
        });

        function cargarFavoritos() {
            // TODO: Implementar API de favoritos
            // Por ahora mostramos mensaje vacío
        }

        function eliminarFavorito(empresaId) {
            if (confirm('¿Quitar esta empresa de favoritos?')) {
                // TODO: Implementar eliminación
                alert('Favorito eliminado (demo)');
            }
        }
    </script>

</body>
</html>

