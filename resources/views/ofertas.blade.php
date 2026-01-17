<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas - ServiLocal</title>
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
        
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">🔥 Ofertas Especiales</h1>
            <p class="text-gray-600">Descuentos y promociones en servicios destacados</p>
        </div>

        <!-- Ofertas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
                <div class="absolute top-4 right-4 bg-red-500 text-white font-bold px-3 py-1 rounded-full text-sm">
                    -20%
                </div>
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center text-3xl mb-4">
                        🔧
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-2">Plomería Express</h3>
                    <p class="text-gray-600 mb-4">20% de descuento en reparaciones de emergencia</p>
                    <div class="flex items-center gap-1 mb-4">
                        <span class="text-yellow-500">⭐</span>
                        <span class="font-semibold">4.8</span>
                        <span class="text-sm text-gray-500">(124 reseñas)</span>
                    </div>
                    <a href="/empresa/1" class="block w-full text-center bg-purple-600 text-white font-semibold py-3 rounded-lg hover:bg-purple-700 transition-all">
                        Ver Oferta
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
                <div class="absolute top-4 right-4 bg-red-500 text-white font-bold px-3 py-1 rounded-full text-sm">
                    -15%
                </div>
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center text-3xl mb-4">
                        ⚡
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-2">Electricidad Pro</h3>
                    <p class="text-gray-600 mb-4">15% OFF en instalaciones eléctricas</p>
                    <div class="flex items-center gap-1 mb-4">
                        <span class="text-yellow-500">⭐</span>
                        <span class="font-semibold">4.9</span>
                        <span class="text-sm text-gray-500">(89 reseñas)</span>
                    </div>
                    <a href="/empresa/2" class="block w-full text-center bg-purple-600 text-white font-semibold py-3 rounded-lg hover:bg-purple-700 transition-all">
                        Ver Oferta
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
                <div class="absolute top-4 right-4 bg-red-500 text-white font-bold px-3 py-1 rounded-full text-sm">
                    -25%
                </div>
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center text-3xl mb-4">
                        🏗️
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-2">Construcciones Atlas</h3>
                    <p class="text-gray-600 mb-4">25% de descuento en remodelaciones</p>
                    <div class="flex items-center gap-1 mb-4">
                        <span class="text-yellow-500">⭐</span>
                        <span class="font-semibold">4.7</span>
                        <span class="text-sm text-gray-500">(156 reseñas)</span>
                    </div>
                    <a href="/empresa/3" class="block w-full text-center bg-purple-600 text-white font-semibold py-3 rounded-lg hover:bg-purple-700 transition-all">
                        Ver Oferta
                    </a>
                </div>
            </div>

        </div>

        <!-- Banner Informativo -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-700 rounded-lg p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-2">¿Eres empresa?</h2>
            <p class="mb-6">Publica tus ofertas y promociones para atraer más clientes</p>
            <a href="/registro" class="inline-block bg-white text-purple-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-all">
                Registrar Empresa
            </a>
        </div>

    </div>

</body>
</html>

