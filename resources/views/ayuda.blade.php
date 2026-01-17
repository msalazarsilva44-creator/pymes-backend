<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda - ServiLocal</title>
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
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">❓ Centro de Ayuda</h1>
            <p class="text-gray-600">Encuentra respuestas a tus preguntas</p>
        </div>

        <!-- Búsqueda -->
        <div class="mb-12">
            <input type="text" placeholder="Buscar en ayuda..." class="w-full px-6 py-4 rounded-lg border-2 border-gray-300 focus:border-purple-500 focus:outline-none text-lg">
        </div>

        <!-- Categorías de Ayuda -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all cursor-pointer">
                <div class="text-4xl mb-3">🔍</div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">¿Cómo buscar servicios?</h3>
                <p class="text-gray-600 text-sm">Aprende a encontrar el servicio perfecto para tus necesidades</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all cursor-pointer">
                <div class="text-4xl mb-3">⭐</div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Sistema de reseñas</h3>
                <p class="text-gray-600 text-sm">Cómo calificar y escribir reseñas de empresas</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all cursor-pointer">
                <div class="text-4xl mb-3">👤</div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Gestionar mi perfil</h3>
                <p class="text-gray-600 text-sm">Edita tu información personal y preferencias</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all cursor-pointer">
                <div class="text-4xl mb-3">🏢</div>
                <h3 class="font-bold text-xl text-gray-900 mb-2">Para empresas</h3>
                <p class="text-gray-600 text-sm">Información sobre cómo registrar tu negocio</p>
            </div>
        </div>

        <!-- Preguntas Frecuentes -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Preguntas Frecuentes</h2>
            
            <div class="space-y-6">
                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer font-semibold text-gray-900 hover:text-purple-600">
                        ¿ServiLocal es gratis para clientes?
                        <span class="group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600">Sí, ServiLocal es completamente gratuito para clientes. Puedes buscar, contactar y calificar empresas sin ningún costo.</p>
                </details>

                <details class="group border-t pt-6">
                    <summary class="flex justify-between items-center cursor-pointer font-semibold text-gray-900 hover:text-purple-600">
                        ¿Cómo sé si una empresa es confiable?
                        <span class="group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600">Las empresas verificadas tienen un badge especial. Además, puedes revisar las calificaciones y reseñas de otros clientes antes de contactar.</p>
                </details>

                <details class="group border-t pt-6">
                    <summary class="flex justify-between items-center cursor-pointer font-semibold text-gray-900 hover:text-purple-600">
                        ¿Puedo modificar o eliminar mis reseñas?
                        <span class="group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600">Sí, puedes editar o eliminar tus reseñas en cualquier momento desde tu perfil en la sección "Mis Reseñas".</p>
                </details>

                <details class="group border-t pt-6">
                    <summary class="flex justify-between items-center cursor-pointer font-semibold text-gray-900 hover:text-purple-600">
                        ¿Qué hago si tengo un problema con una empresa?
                        <span class="group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600">Puedes reportar el problema a través de nuestro formulario de contacto. Nuestro equipo revisará el caso y tomará las medidas necesarias.</p>
                </details>
            </div>
        </div>

        <!-- Contacto -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-700 rounded-lg p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-2">¿No encuentras lo que buscas?</h2>
            <p class="mb-6">Contáctanos y te ayudaremos a resolver tu duda</p>
            <a href="mailto:soporte@servilocal.com" class="inline-block bg-white text-purple-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-all">
                📧 soporte@servilocal.com
            </a>
        </div>

    </div>

</body>
</html>

