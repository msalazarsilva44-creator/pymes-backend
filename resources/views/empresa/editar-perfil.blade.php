<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - ServiLocal Empresa</title>
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
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">✏️ Editar Perfil de Empresa</h1>
            <p class="text-gray-600">Actualiza la información de tu negocio</p>
        </div>

        <!-- Mensajes -->
        <div id="mensaje" class="hidden mb-6 p-4 rounded-lg"></div>

        <!-- Formulario -->
        <form id="form-perfil" class="space-y-6">
            
            <!-- Logo de la Empresa -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Logo de la Empresa</h2>
                
                <div class="flex items-start gap-6">
                    <!-- Preview del Logo -->
                    <div class="flex-shrink-0">
                        <div class="w-32 h-32 rounded-lg border-2 border-gray-300 flex items-center justify-center overflow-hidden bg-gray-50">
                            <img id="logo-preview" src="" alt="Logo" class="w-full h-full object-cover hidden">
                            <span id="logo-placeholder" class="text-5xl">🏢</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-center">Recomendado:<br>500x500px</p>
                    </div>
                    
                    <!-- Upload -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Subir Logo
                        </label>
                        <input 
                            type="file" 
                            id="logo-input"
                            accept="image/*"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, JPEG hasta 2MB. El logo aparecerá en tu perfil público.</p>
                        
                        <button 
                            type="button"
                            onclick="subirLogo()"
                            id="btn-subir-logo"
                            class="mt-4 bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            📤 Subir Logo
                        </button>
                        
                        <button 
                            type="button"
                            onclick="eliminarLogo()"
                            id="btn-eliminar-logo"
                            class="mt-4 ml-3 bg-red-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-700 transition-all hidden"
                        >
                            🗑️ Eliminar Logo
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Información Básica -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Información Básica</h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Comercial *
                            </label>
                            <input 
                                type="text" 
                                name="nombre_comercial" 
                                id="nombre_comercial"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                RIF/RUC
                            </label>
                            <input 
                                type="text" 
                                name="rfc" 
                                id="rfc"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Categoría *
                            </label>
                            <select 
                                name="categoria_id" 
                                id="categoria_id"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                                <option value="">Seleccionar categoría...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ciudad *
                            </label>
                            <select 
                                name="ciudad_id" 
                                id="ciudad_id"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                                <option value="">Seleccionar ciudad...</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción de la Empresa *
                        </label>
                        <textarea 
                            name="descripcion" 
                            id="descripcion"
                            rows="4"
                            required
                            placeholder="Describe tu empresa, servicios que ofreces, años de experiencia..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        ></textarea>
                        <p class="text-xs text-gray-500 mt-1">Una buena descripción ayuda a los clientes a conocerte mejor</p>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Información de Contacto</h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono Principal *
                            </label>
                            <input 
                                type="tel" 
                                name="telefono" 
                                id="telefono"
                                required
                                placeholder="+58 424 1234567"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email de Contacto *
                            </label>
                            <input 
                                type="email" 
                                name="email_contacto" 
                                id="email_contacto"
                                required
                                placeholder="contacto@tuempresa.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección Completa *
                        </label>
                        <textarea 
                            name="direccion" 
                            id="direccion"
                            rows="2"
                            required
                            placeholder="Calle, Número, Zona, Puntos de referencia..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sitio Web (Opcional)
                        </label>
                        <input 
                            type="url" 
                            name="sitio_web" 
                            id="sitio_web"
                            placeholder="https://www.tuempresa.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    </div>
                </div>
            </div>

            <!-- Redes Sociales -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Redes Sociales (Opcional)</h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📘 Facebook
                            </label>
                            <input 
                                type="url" 
                                name="facebook" 
                                id="facebook"
                                placeholder="https://facebook.com/tuempresa"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📷 Instagram
                            </label>
                            <input 
                                type="url" 
                                name="instagram" 
                                id="instagram"
                                placeholder="https://instagram.com/tuempresa"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                🐦 Twitter
                            </label>
                            <input 
                                type="url" 
                                name="twitter" 
                                id="twitter"
                                placeholder="https://twitter.com/tuempresa"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                💼 LinkedIn
                            </label>
                            <input 
                                type="url" 
                                name="linkedin" 
                                id="linkedin"
                                placeholder="https://linkedin.com/company/tuempresa"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                ▶️ YouTube
                            </label>
                            <input 
                                type="url" 
                                name="youtube" 
                                id="youtube"
                                placeholder="https://youtube.com/@tucanal"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                🎵 TikTok
                            </label>
                            <input 
                                type="url" 
                                name="tiktok" 
                                id="tiktok"
                                placeholder="https://tiktok.com/@tuusuario"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex gap-4">
                <button 
                    type="submit"
                    class="flex-1 gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all"
                >
                    💾 Guardar Cambios
                </button>
                <a 
                    href="/dashboard/empresa"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all"
                >
                    Cancelar
                </a>
            </div>

        </form>

    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = '';
        let empresaId = null;

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const userRole = localStorage.getItem('user_role');

            if (!authToken || userRole !== 'empresa') {
                window.location.href = '/login';
                return;
            }

            empresaId = empresaData.id;

            // Cargar categorías y ciudades
            await Promise.all([
                cargarCategorias(),
                cargarCiudades()
            ]);

            // Llenar formulario con datos actuales
            llenarFormulario(empresaData);
            
            // Mostrar logo si existe
            if (empresaData.logo) {
                mostrarLogo(empresaData.logo);
            }
            
            // Setup preview del logo
            setupLogoPreview();
        });

        // Setup preview del logo
        function setupLogoPreview() {
            const input = document.getElementById('logo-input');
            const preview = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-placeholder');
            const btnSubir = document.getElementById('btn-subir-logo');
            
            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    // Validar tamaño (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        mostrarMensaje('❌ El logo no debe superar 2MB', 'error');
                        input.value = '';
                        return;
                    }
                    
                    // Mostrar preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                        btnSubir.disabled = false;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Mostrar logo existente
        function mostrarLogo(logoUrl) {
            const preview = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-placeholder');
            const btnEliminar = document.getElementById('btn-eliminar-logo');
            
            preview.src = logoUrl;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            btnEliminar.classList.remove('hidden');
        }

        // Subir logo
        async function subirLogo() {
            const input = document.getElementById('logo-input');
            const file = input.files[0];
            
            if (!file) {
                mostrarMensaje('❌ Por favor selecciona un archivo', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('logo', file);
            
            try {
                mostrarMensaje('⏳ Subiendo logo...', 'info');
                
                const response = await fetch(`${API_URL}/empresas/${empresaId}/logo`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    mostrarMensaje('✅ ¡Logo actualizado exitosamente!', 'success');
                    
                    // Actualizar localStorage
                    const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
                    empresaData.logo = result.data.logo;
                    localStorage.setItem('empresa_data', JSON.stringify(empresaData));
                    
                    // Mostrar botón eliminar
                    document.getElementById('btn-eliminar-logo').classList.remove('hidden');
                    document.getElementById('btn-subir-logo').disabled = true;
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al subir el logo'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        }

        // Eliminar logo
        async function eliminarLogo() {
            if (!confirm('¿Estás seguro de eliminar el logo?')) {
                return;
            }
            
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/logo`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    mostrarMensaje('✅ Logo eliminado exitosamente', 'success');
                    
                    // Resetear preview
                    document.getElementById('logo-preview').classList.add('hidden');
                    document.getElementById('logo-placeholder').classList.remove('hidden');
                    document.getElementById('btn-eliminar-logo').classList.add('hidden');
                    document.getElementById('logo-input').value = '';
                    
                    // Actualizar localStorage
                    const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
                    empresaData.logo = null;
                    localStorage.setItem('empresa_data', JSON.stringify(empresaData));
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al eliminar el logo'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        }

        // Cargar categorías
        async function cargarCategorias() {
            try {
                const response = await fetch(`${API_URL}/categorias`);
                const result = await response.json();

                if (result.success) {
                    const select = document.getElementById('categoria_id');
                    result.data.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.nombre;
                        select.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error cargando categorías:', error);
            }
        }

        // Cargar ciudades
        async function cargarCiudades() {
            try {
                const response = await fetch(`${API_URL}/ciudades`);
                const result = await response.json();

                if (result.success) {
                    const select = document.getElementById('ciudad_id');
                    result.data.forEach(ciudad => {
                        const option = document.createElement('option');
                        option.value = ciudad.id;
                        option.textContent = `${ciudad.nombre}, ${ciudad.estado}`;
                        select.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error cargando ciudades:', error);
            }
        }

        // Llenar formulario con datos actuales
        function llenarFormulario(empresa) {
            document.getElementById('nombre_comercial').value = empresa.nombre_comercial || '';
            document.getElementById('rfc').value = empresa.rfc || '';
            document.getElementById('descripcion').value = empresa.descripcion || '';
            document.getElementById('telefono').value = empresa.telefono || '';
            document.getElementById('email_contacto').value = empresa.email_contacto || '';
            document.getElementById('direccion').value = empresa.direccion || '';
            document.getElementById('sitio_web').value = empresa.sitio_web || '';
            document.getElementById('facebook').value = empresa.facebook || '';
            document.getElementById('instagram').value = empresa.instagram || '';
            document.getElementById('twitter').value = empresa.twitter || '';
            document.getElementById('linkedin').value = empresa.linkedin || '';
            document.getElementById('youtube').value = empresa.youtube || '';
            document.getElementById('tiktok').value = empresa.tiktok || '';

            // Seleccionar categoría y ciudad cuando se carguen
            setTimeout(() => {
                if (empresa.categoria_id) {
                    document.getElementById('categoria_id').value = empresa.categoria_id;
                }
                if (empresa.ciudad_id) {
                    document.getElementById('ciudad_id').value = empresa.ciudad_id;
                }
            }, 500);
        }

        // Guardar cambios
        document.getElementById('form-perfil').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            
            const data = {
                nombre_comercial: formData.get('nombre_comercial'),
                rfc: formData.get('rfc'),
                categoria_id: formData.get('categoria_id'),
                ciudad_id: formData.get('ciudad_id'),
                descripcion: formData.get('descripcion'),
                telefono: formData.get('telefono'),
                email_contacto: formData.get('email_contacto'),
                direccion: formData.get('direccion'),
                sitio_web: formData.get('sitio_web'),
                facebook: formData.get('facebook'),
                instagram: formData.get('instagram'),
                twitter: formData.get('twitter'),
                linkedin: formData.get('linkedin'),
                youtube: formData.get('youtube'),
                tiktok: formData.get('tiktok')
            };

            // Debug: ver qué datos se están enviando
            console.log('Datos a enviar:', data);
            console.log('Redes sociales:', {
                facebook: data.facebook,
                instagram: data.instagram,
                twitter: data.twitter,
                linkedin: data.linkedin,
                youtube: data.youtube,
                tiktok: data.tiktok
            });

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    // Actualizar localStorage
                    localStorage.setItem('empresa_data', JSON.stringify(result.data));
                    
                    mostrarMensaje('✅ ¡Perfil actualizado exitosamente!', 'success');
                    
                    // Redirigir al dashboard después de 2 segundos
                    setTimeout(() => {
                        window.location.href = '/dashboard/empresa';
                    }, 2000);
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al actualizar el perfil'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        });

        // Mostrar mensajes
        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            mensaje.className = `mb-6 p-4 rounded-lg ${tipo === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'}`;
            mensaje.textContent = texto;
            mensaje.classList.remove('hidden');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

</body>
</html>

