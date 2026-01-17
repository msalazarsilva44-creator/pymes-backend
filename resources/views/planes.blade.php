<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes y Precios - ServiLocal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                        ServiLocal
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/dashboard/empresa" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6 float-animation">
                Impulsa tu Negocio 🚀
            </h1>
            <p class="text-xl opacity-90 max-w-2xl mx-auto mb-8">
                Elige el plan perfecto para llevar tu empresa al siguiente nivel y conectar con más clientes
            </p>
            <div class="flex justify-center gap-4">
                <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                    ✨ Sin permanencia
                </span>
                <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                    💳 Pago seguro
                </span>
                <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                    🎯 Cancela cuando quieras
                </span>
            </div>
        </div>
    </section>

    <!-- Planes Section -->
    <section class="py-20 -mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Plan Gratis -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <div class="inline-block p-3 bg-gray-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Gratis</h3>
                            <div class="text-4xl font-bold text-gray-900 mb-1">
                                $0
                                <span class="text-lg font-normal text-gray-500">/mes</span>
                            </div>
                            <p class="text-gray-600 text-sm">Perfecto para empezar</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-600">Perfil básico</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-600">1 foto de perfil</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-600">Listado en marketplace</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-600">Reseñas de clientes</span>
                            </li>
                            <li class="flex items-start gap-3 opacity-40">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-gray-400">Sin panel de métricas</span>
                            </li>
                            <li class="flex items-start gap-3 opacity-40">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-gray-400">Sin notificaciones</span>
                            </li>
                            <li class="flex items-start gap-3 opacity-40">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-gray-400">Sin prioridad</span>
                            </li>
                        </ul>

                        <button onclick="window.location.href='/dashboard/empresa'" class="w-full bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-300 transition-colors">
                            Plan Actual
                        </button>
                    </div>
                </div>

                <!-- Plan Básico -->
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-2 border-blue-500 hover:shadow-2xl transition-shadow relative transform scale-105">
                    <div class="absolute top-0 right-0 bg-blue-500 text-white px-4 py-1 text-sm font-bold rounded-bl-lg">
                        🔥 POPULAR
                    </div>
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <div class="inline-block p-3 bg-blue-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Básico</h3>
                            <div class="text-5xl font-bold text-blue-600 mb-1">
                                $5
                                <span class="text-lg font-normal text-gray-500">/mes</span>
                            </div>
                            <p class="text-gray-600 text-sm">Mayor visibilidad</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700 font-medium">Todo del plan Gratis +</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700"><strong>10 fotos</strong> de galería</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Boost de 2 días</strong> en portada</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Panel de métricas básico</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Perfil destacado</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Soporte prioritario</span>
                            </li>
                        </ul>

                        <button onclick="seleccionarPlan('basico')" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                            Elegir Básico
                        </button>
                    </div>
                </div>

                <!-- Plan Premium -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl shadow-2xl overflow-hidden border-2 border-purple-500 hover:shadow-2xl transition-shadow relative text-white">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-purple-900 px-4 py-1 text-sm font-bold rounded-bl-lg">
                        ⭐ PREMIUM
                    </div>
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <div class="inline-block p-3 bg-white/20 backdrop-blur-sm rounded-full mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Premium</h3>
                            <div class="text-5xl font-bold mb-1">
                                $10
                                <span class="text-lg font-normal opacity-90">/mes</span>
                            </div>
                            <p class="opacity-90 text-sm">Máxima visibilidad</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-medium">Todo del plan Básico +</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><strong>Fotos ilimitadas</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><strong>Top en tu categoría</strong> 🏆</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><strong>Panel de métricas avanzado</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><strong>Notificaciones de clientes</strong> 🔔</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><strong>Prioridad por calificación</strong></span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Insignia de verificación</span>
                            </li>
                        </ul>

                        <button onclick="seleccionarPlan('premium')" class="w-full bg-white text-purple-600 font-semibold py-3 rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                            Elegir Premium
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Comparación Detallada -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                Comparación Detallada
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-6 text-gray-700 font-semibold">Característica</th>
                            <th class="text-center py-4 px-6 text-gray-700 font-semibold">Gratis</th>
                            <th class="text-center py-4 px-6 text-blue-600 font-semibold">Básico</th>
                            <th class="text-center py-4 px-6 text-purple-600 font-semibold">Premium</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Perfil de empresa</td>
                            <td class="text-center py-4 px-6">✅</td>
                            <td class="text-center py-4 px-6">✅</td>
                            <td class="text-center py-4 px-6">✅</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Número de fotos</td>
                            <td class="text-center py-4 px-6">1</td>
                            <td class="text-center py-4 px-6 font-semibold text-blue-600">10</td>
                            <td class="text-center py-4 px-6 font-semibold text-purple-600">Ilimitadas</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Panel de métricas</td>
                            <td class="text-center py-4 px-6">❌</td>
                            <td class="text-center py-4 px-6 text-blue-600">Básico</td>
                            <td class="text-center py-4 px-6 text-purple-600">Avanzado</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Notificaciones de clientes</td>
                            <td class="text-center py-4 px-6">❌</td>
                            <td class="text-center py-4 px-6">❌</td>
                            <td class="text-center py-4 px-6">✅</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Boost en portada</td>
                            <td class="text-center py-4 px-6">-</td>
                            <td class="text-center py-4 px-6 font-semibold text-blue-600">2 días</td>
                            <td class="text-center py-4 px-6">-</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Posición en marketplace</td>
                            <td class="text-center py-4 px-6">Final</td>
                            <td class="text-center py-4 px-6 text-blue-600">Media</td>
                            <td class="text-center py-4 px-6 text-purple-600">Top (por calificación)</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Insignia de verificación</td>
                            <td class="text-center py-4 px-6">❌</td>
                            <td class="text-center py-4 px-6">❌</td>
                            <td class="text-center py-4 px-6">✅</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">Soporte</td>
                            <td class="text-center py-4 px-6">Email</td>
                            <td class="text-center py-4 px-6">Prioritario</td>
                            <td class="text-center py-4 px-6">VIP</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                Preguntas Frecuentes
            </h2>

            <div class="space-y-6">
                <details class="bg-white rounded-lg shadow-sm p-6 cursor-pointer">
                    <summary class="font-semibold text-gray-900 text-lg">¿Puedo cambiar de plan en cualquier momento?</summary>
                    <p class="mt-4 text-gray-600">Sí, puedes actualizar o cancelar tu plan cuando quieras. Sin permanencia ni penalizaciones.</p>
                </details>

                <details class="bg-white rounded-lg shadow-sm p-6 cursor-pointer">
                    <summary class="font-semibold text-gray-900 text-lg">¿Cómo funciona el boost de 2 días?</summary>
                    <p class="mt-4 text-gray-600">Al contratar el plan Básico, tu empresa aparecerá en la página principal durante 2 días. Después, se posicionará según tu categoría y calificación, pero con mejor visibilidad que las cuentas gratuitas.</p>
                </details>

                <details class="bg-white rounded-lg shadow-sm p-6 cursor-pointer">
                    <summary class="font-semibold text-gray-900 text-lg">¿Qué métodos de pago aceptan?</summary>
                    <p class="mt-4 text-gray-600">Aceptamos tarjetas de crédito, débito y transferencias bancarias. Pagos 100% seguros.</p>
                </details>

                <details class="bg-white rounded-lg shadow-sm p-6 cursor-pointer">
                    <summary class="font-semibold text-gray-900 text-lg">¿El plan Premium garantiza más clientes?</summary>
                    <p class="mt-4 text-gray-600">El plan Premium te da máxima visibilidad, métricas avanzadas y notificaciones de clientes interesados. Esto aumenta significativamente tus oportunidades de negocio, pero el éxito también depende de tu servicio y calificaciones.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="gradient-bg text-white py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">
                ¿Listo para Crecer?
            </h2>
            <p class="text-xl opacity-90 mb-8">
                Únete a cientos de empresas que ya confían en ServiLocal
            </p>
            <div class="flex justify-center gap-4">
                <button onclick="seleccionarPlan('basico')" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Empezar con Básico
                </button>
                <button onclick="seleccionarPlan('premium')" class="bg-purple-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-900 transition-colors border-2 border-white/30">
                    Ir a Premium
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">© 2025 ServiLocal. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function seleccionarPlan(plan) {
            // Verificar si el usuario está autenticado
            const authToken = localStorage.getItem('auth_token');
            const userRole = localStorage.getItem('user_role');

            if (!authToken) {
                // Si no está autenticado, redirigir al login
                if (confirm('Debes iniciar sesión para contratar un plan. ¿Deseas ir al login?')) {
                    window.location.href = '/login';
                }
                return;
            }

            // Verificar que sea una empresa
            if (userRole !== 'empresa') {
                alert('⚠️ Solo las empresas pueden contratar planes de suscripción.');
                return;
            }

            // Redirigir a la página de solicitud de plan
            window.location.href = '/empresa/solicitar-plan';
        }

        // Detectar plan actual del usuario (si está autenticado)
        document.addEventListener('DOMContentLoaded', function() {
            const authToken = localStorage.getItem('auth_token');
            
            // Si no hay token, redirigir al login
            if (!authToken) {
                window.location.href = '/login';
                return;
            }

            // Obtener datos de la empresa para destacar su plan actual
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            if (empresaData.plan) {
                highlightCurrentPlan(empresaData.plan.slug);
            }
        });

        // Destacar el plan actual del usuario
        function highlightCurrentPlan(planSlug) {
            // Agregar badge "Plan Actual" al plan correspondiente
            const planCards = document.querySelectorAll('.bg-white.rounded-2xl, .bg-gradient-to-br');
            
            planCards.forEach(card => {
                const button = card.querySelector('button');
                if (!button) return;

                const buttonText = button.textContent.trim();
                
                if ((planSlug === 'gratis' && buttonText === 'Plan Actual') ||
                    (planSlug === 'basico' && buttonText.includes('Básico')) ||
                    (planSlug === 'premium' && buttonText.includes('Premium'))) {
                    
                    // Agregar badge de "Plan Actual"
                    const badge = document.createElement('div');
                    badge.className = 'absolute top-4 left-4 bg-green-500 text-white px-3 py-1 text-xs font-bold rounded-full';
                    badge.textContent = '✓ Tu Plan Actual';
                    card.style.position = 'relative';
                    card.insertBefore(badge, card.firstChild);
                    
                    // Deshabilitar el botón si es el plan actual
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                    button.textContent = 'Plan Actual';
                }
            });
        }
    </script>

</body>
</html>

