<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - ServiLocal</title>
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
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mi Perfil</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center text-4xl text-white font-bold" id="avatar-display">
                            U
                        </div>
                        <h3 class="font-bold text-lg text-gray-900" id="user-name-display">Usuario</h3>
                        <p class="text-sm text-gray-600" id="user-email-display">email@ejemplo.com</p>
                    </div>

                    <div class="space-y-2">
                        <button onclick="mostrarSeccion('info')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-purple-50 transition-all seccion-btn" data-seccion="info">
                            👤 Información Personal
                        </button>
                        <button onclick="mostrarSeccion('password')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-purple-50 transition-all seccion-btn" data-seccion="password">
                            🔒 Cambiar Contraseña
                        </button>
                        <button onclick="mostrarSeccion('resenas')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-purple-50 transition-all seccion-btn" data-seccion="resenas">
                            ⭐ Mis Reseñas
                        </button>
                        <button onclick="mostrarSeccion('estadisticas')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-purple-50 transition-all seccion-btn" data-seccion="estadisticas">
                            📊 Estadísticas
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="lg:col-span-2">
                
                <!-- Información Personal -->
                <div id="seccion-info" class="bg-white rounded-lg shadow-md p-6 seccion-content">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Información Personal</h2>
                    
                    <div id="mensaje-info" class="hidden mb-4 p-4 rounded-lg"></div>

                    <form id="form-info" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                                <input type="text" name="name" id="input-name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
                                <input type="text" name="apellido" id="input-apellido" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                            <input type="email" name="email" id="input-email" disabled class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">El correo no puede ser modificado</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cédula</label>
                                <input type="text" name="cedula" id="input-cedula" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                <input type="tel" name="phone" id="input-phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                            <textarea name="direccion" id="input-direccion" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-purple-600 text-white font-semibold py-3 rounded-lg hover:bg-purple-700 transition-all">
                            💾 Guardar Cambios
                        </button>
                    </form>
                </div>

                <!-- Cambiar Contraseña -->
                <div id="seccion-password" class="hidden bg-white rounded-lg shadow-md p-6 seccion-content">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Cambiar Contraseña</h2>
                    
                    <div id="mensaje-password" class="hidden mb-4 p-4 rounded-lg"></div>

                    <form id="form-password" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                            <input type="password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                            <input type="password" name="new_password" required minlength="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
                            <input type="password" name="new_password_confirmation" required minlength="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <button type="submit" class="w-full bg-purple-600 text-white font-semibold py-3 rounded-lg hover:bg-purple-700 transition-all">
                            🔒 Cambiar Contraseña
                        </button>
                    </form>
                </div>

                <!-- Mis Reseñas -->
                <div id="seccion-resenas" class="hidden bg-white rounded-lg shadow-md p-6 seccion-content">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Mis Reseñas</h2>
                    <div id="lista-resenas" class="space-y-4">
                        <div class="text-center py-8 text-gray-500">
                            No has escrito reseñas todavía
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div id="seccion-estadisticas" class="hidden bg-white rounded-lg shadow-md p-6 seccion-content">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Estadísticas</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-6 bg-blue-50 rounded-lg">
                            <p class="text-3xl font-bold text-blue-600">0</p>
                            <p class="text-sm text-gray-600 mt-2">Búsquedas realizadas</p>
                        </div>
                        <div class="text-center p-6 bg-purple-50 rounded-lg">
                            <p class="text-3xl font-bold text-purple-600">0</p>
                            <p class="text-sm text-gray-600 mt-2">Favoritos guardados</p>
                        </div>
                        <div class="text-center p-6 bg-green-50 rounded-lg">
                            <p class="text-3xl font-bold text-green-600">0</p>
                            <p class="text-sm text-gray-600 mt-2">Reseñas escritas</p>
                        </div>
                        <div class="text-center p-6 bg-yellow-50 rounded-lg">
                            <p class="text-3xl font-bold text-yellow-600">0</p>
                            <p class="text-sm text-gray-600 mt-2">Empresas contactadas</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = '';

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');

            if (!authToken) {
                window.location.href = '/login';
                return;
            }

            // Llenar formulario con datos del usuario
            document.getElementById('user-name-display').textContent = `${userData.name || ''} ${userData.apellido || ''}`.trim();
            document.getElementById('user-email-display').textContent = userData.email || '';
            document.getElementById('avatar-display').textContent = (userData.name || 'U').charAt(0).toUpperCase();

            document.getElementById('input-name').value = userData.name || '';
            document.getElementById('input-apellido').value = userData.apellido || '';
            document.getElementById('input-email').value = userData.email || '';
            document.getElementById('input-cedula').value = userData.cedula || '';
            document.getElementById('input-phone').value = userData.phone || '';
            document.getElementById('input-direccion').value = userData.direccion || '';

            // Activar sección por defecto
            mostrarSeccion('info');
        });

        // Mostrar sección
        function mostrarSeccion(seccion) {
            // Ocultar todas las secciones
            document.querySelectorAll('.seccion-content').forEach(el => el.classList.add('hidden'));
            
            // Remover activo de botones
            document.querySelectorAll('.seccion-btn').forEach(btn => {
                btn.classList.remove('bg-purple-100', 'font-semibold');
            });

            // Mostrar sección seleccionada
            document.getElementById(`seccion-${seccion}`).classList.remove('hidden');
            
            // Activar botón
            const btnActivo = document.querySelector(`[data-seccion="${seccion}"]`);
            if (btnActivo) {
                btnActivo.classList.add('bg-purple-100', 'font-semibold');
            }
        }

        // Actualizar información
        document.getElementById('form-info').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            
            // Nota: Este endpoint necesita ser implementado en el backend
            const data = {
                name: formData.get('name'),
                apellido: formData.get('apellido'),
                cedula: formData.get('cedula'),
                phone: formData.get('phone'),
                direccion: formData.get('direccion')
            };

            try {
                // Por ahora, solo actualizamos localStorage
                const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
                Object.assign(userData, data);
                localStorage.setItem('user_data', JSON.stringify(userData));

                mostrarMensaje('mensaje-info', '✅ Información actualizada exitosamente', 'success');
                
                // Actualizar display
                document.getElementById('user-name-display').textContent = `${data.name || ''} ${data.apellido || ''}`.trim();
            } catch (error) {
                mostrarMensaje('mensaje-info', '❌ Error al actualizar información', 'error');
                console.error('Error:', error);
            }
        });

        // Cambiar contraseña
        document.getElementById('form-password').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            if (formData.get('new_password') !== formData.get('new_password_confirmation')) {
                mostrarMensaje('mensaje-password', '❌ Las contraseñas no coinciden', 'error');
                return;
            }

            // Por ahora solo mostramos mensaje
            mostrarMensaje('mensaje-password', '✅ Contraseña actualizada exitosamente (demo)', 'success');
            e.target.reset();
        });

        // Mostrar mensajes
        function mostrarMensaje(elementId, texto, tipo) {
            const elemento = document.getElementById(elementId);
            elemento.className = `mb-4 p-4 rounded-lg ${tipo === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
            elemento.textContent = texto;
            elemento.classList.remove('hidden');

            setTimeout(() => {
                elemento.classList.add('hidden');
            }, 5000);
        }
    </script>

</body>
</html>

