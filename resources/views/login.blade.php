<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ServiLocal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .main-bg {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold gradient-text">
                    ServiLocal
                </a>
                <a href="/" class="text-gray-600 hover:text-gray-900">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </header>

    <!-- Formulario de Login -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            
            <!-- Título -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Bienvenido de nuevo</h1>
                <p class="text-gray-600">Inicia sesión en tu cuenta de ServiLocal</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                
                <!-- Mensaje de resultado -->
                <div id="mensaje" class="hidden mb-4 p-4 rounded-lg"></div>

                <!-- Formulario -->
                <form id="form-login" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            required
                            placeholder="tu@email.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                        >
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                        <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button 
                        type="submit"
                        class="w-full gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5"
                    >
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">o</span>
                    </div>
                </div>

                <!-- Link a Registro -->
                <div class="text-center">
                    <p class="text-gray-600">
                        ¿No tienes cuenta? 
                        <a href="/registro" class="text-purple-600 hover:text-purple-700 font-semibold">
                            Regístrate aquí
                        </a>
                    </p>
                </div>

            </div>

            <!-- Usuarios de prueba -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm font-semibold text-blue-900 mb-2">👤 Usuarios de Prueba:</p>
                <div class="text-xs text-blue-800 space-y-1">
                    <p><strong>Admin:</strong> admin@servilocal.com / password</p>
                    <p><strong>Cliente:</strong> cliente@test.com / password</p>
                    <p><strong>Empresa:</strong> maria@plomeria.com / password</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Función para mostrar mensajes
        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            mensaje.className = `mb-4 p-4 rounded-lg ${tipo === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'}`;
            mensaje.textContent = texto;
            mensaje.classList.remove('hidden');
            
            setTimeout(() => {
                mensaje.classList.add('hidden');
            }, 5000);
        }

        // Login Web (crea sesión web + token API)
        document.getElementById('form-login').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            
            const data = {
                email: formData.get('email'),
                password: formData.get('password')
            };

            try {
                const response = await fetch('/web/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    // Guardar token en localStorage para uso de API
                    localStorage.setItem('auth_token', result.data.access_token);
                    localStorage.setItem('user_data', JSON.stringify(result.data.user));
                    localStorage.setItem('user_role', result.data.user.role.name);
                    
                    if (result.data.empresa) {
                        localStorage.setItem('empresa_data', JSON.stringify(result.data.empresa));
                    }

                    mostrarMensaje('✅ ¡Login exitoso! Redirigiendo...', 'success');
                    
                    // Redirigir según el rol
                    setTimeout(() => {
                        const role = result.data.user.role.name;
                        if (role === 'cliente') {
                            window.location.href = '/dashboard/cliente';
                        } else if (role === 'empresa') {
                            window.location.href = '/dashboard/empresa';
                        } else if (role === 'admin') {
                            window.location.href = '/dashboard/admin';
                        } else {
                            window.location.href = '/';
                        }
                    }, 1500);
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Credenciales incorrectas'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        });
    </script>

</body>
</html>

