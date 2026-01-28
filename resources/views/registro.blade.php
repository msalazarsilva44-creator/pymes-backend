<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - MERCAROF</title>
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * {
            font-family: 'Inter', sans-serif;
        }
        .tab-active {
            background: linear-gradient(135deg, #00A3E0 0%, #0082B8 100%);
            color: white;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%);
        }
        .main-bg {
            background-color: #f3f4f6;
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .logo-container img {
            height: 40px;
            width: auto;
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="logo-container">
                    <img src="/logo-mercarof.jpeg" alt="MERCAROF Logo">
                    <span class="text-2xl font-bold text-mercarof-navy">MERCAROF</span>
                </a>
                <a href="/" class="text-mercarof-navy hover:text-mercarof-cyan transition-colors">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </header>

    <!-- Formulario de Registro -->
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            
            <!-- Título -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-mercarof-navy mb-2">Crear Cuenta</h1>
                <p class="text-gray-600">Únete a MERCAROF y empieza a conectar</p>
            </div>

            <!-- Tabs -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex gap-2 mb-6 bg-gray-100 p-1 rounded-lg">
                    <button 
                        id="tab-cliente" 
                        onclick="cambiarTab('cliente')" 
                        class="tab-active flex-1 py-3 rounded-lg font-semibold transition-all duration-300">
                        👤 ¿Eres Cliente?
                    </button>
                    <button 
                        id="tab-empresa" 
                        onclick="cambiarTab('empresa')" 
                        class="flex-1 py-3 rounded-lg font-semibold text-gray-600 hover:text-gray-900 transition-all duration-300">
                        🏢 ¿Eres Empresa?
                    </button>
                </div>

                <!-- Mensaje de resultado -->
                <div id="mensaje" class="hidden mb-4 p-4 rounded-lg"></div>

                <!-- Formulario Cliente -->
                <form id="form-cliente" class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Formulario de Cliente</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                            <input type="text" name="nombre" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Apellido *</label>
                            <input type="text" name="apellido" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cédula * <span class="text-xs text-gray-500">(11 dígitos)</span></label>
                        <input type="text" name="cedula" id="cedula-cliente" required placeholder="12345678901" maxlength="11" pattern="\d{11}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            title="La cédula debe tener exactamente 11 dígitos numéricos">
                        <p id="error-cedula" class="text-xs text-red-600 mt-1 hidden">La cédula debe tener exactamente 11 dígitos</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                        <input type="tel" name="telefono" required placeholder="0414-1234567"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                        <textarea name="direccion" required rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                        <input type="password" name="password" required minlength="8"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Mínimo 8 caracteres</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" required minlength="8"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>

                    <button type="submit" 
                        class="w-full gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all duration-300">
                        Crear Cuenta Cliente
                    </button>
                </form>

                <!-- Formulario Empresa -->
                <form id="form-empresa" class="space-y-4 hidden">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Formulario de Empresa</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Empresa *</label>
                        <input type="text" name="nombre_empresa" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">RIF * <span class="text-xs text-gray-500">(Máximo 10 dígitos)</span></label>
                        <input type="text" name="rif" required placeholder="J-12345678" maxlength="10" pattern="[A-Za-z]-?\d{7,9}"
                            title="Formato: J-12345678 (máximo 10 caracteres)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Ejemplo: J-12345678 o V-12345678</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            📄 Documento RIF (PDF) * 
                            <span class="text-xs text-gray-500">(Para verificación - Máx. 5MB)</span>
                        </label>
                        <input type="file" name="documento_rif" required accept=".pdf" id="documento-rif-input"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-mercarof-cyan file:bg-opacity-10 file:text-mercarof-cyan hover:file:bg-opacity-20">
                        <p class="text-xs text-gray-500 mt-1">
                            🔒 <strong>Importante:</strong> Suba el documento RIF de su empresa en formato PDF. Este documento será revisado por nuestro equipo para verificar la autenticidad de su empresa y evitar fraudes.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoría de la Empresa *</label>
                        <select name="categoria" required id="categoria-select"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                            <option value="">Seleccione una categoría...</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                            <select name="ciudad" required id="ciudad-select" onchange="cargarMunicipios()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                                <option value="">Seleccione un estado...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Municipio *</label>
                            <select name="municipio" required id="municipio-select"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                                <option value="">Primero seleccione un estado...</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                        <textarea name="direccion_empresa" required rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reseña - ¿A qué se dedica? *</label>
                        <textarea name="resena" required rows="4" placeholder="Describa los servicios que ofrece su empresa..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Responsable *</label>
                            <input type="text" name="nombre_responsable" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Apellido del Responsable *</label>
                            <input type="text" name="apellido_responsable" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email de Contacto *</label>
                        <input type="email" name="email_empresa" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono de Contacto *</label>
                        <input type="tel" name="telefono_empresa" required placeholder="0212-1234567"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                        <input type="password" name="password_empresa" required minlength="8"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Mínimo 8 caracteres</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation_empresa" required minlength="8"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>

                    <button type="submit" 
                        class="w-full gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all duration-300">
                        Crear Cuenta Empresa
                    </button>
                </form>

            </div>

            <!-- Link para login -->
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    ¿Ya tienes cuenta? 
                    <a href="/login" class="text-mercarof-cyan hover:text-mercarof-cyan-dark font-semibold">Inicia sesión aquí</a>
                </p>
            </div>

        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';

        // Cambiar entre tabs
        function cambiarTab(tipo) {
            const tabCliente = document.getElementById('tab-cliente');
            const tabEmpresa = document.getElementById('tab-empresa');
            const formCliente = document.getElementById('form-cliente');
            const formEmpresa = document.getElementById('form-empresa');

            if (tipo === 'cliente') {
                tabCliente.classList.add('tab-active');
                tabCliente.classList.remove('text-gray-600');
                tabEmpresa.classList.remove('tab-active');
                tabEmpresa.classList.add('text-gray-600');
                formCliente.classList.remove('hidden');
                formEmpresa.classList.add('hidden');
            } else {
                tabEmpresa.classList.add('tab-active');
                tabEmpresa.classList.remove('text-gray-600');
                tabCliente.classList.remove('tab-active');
                tabCliente.classList.add('text-gray-600');
                formEmpresa.classList.remove('hidden');
                formCliente.classList.add('hidden');
            }
        }

        // Cargar categorías y ciudades al cargar la página
        window.addEventListener('DOMContentLoaded', async () => {
            try {
                // Cargar categorías
                const categoriasRes = await fetch(`${API_URL}/categorias`);
                const categoriasData = await categoriasRes.json();
                const categoriaSelect = document.getElementById('categoria-select');
                
                if (categoriasData.success && categoriasData.data) {
                    categoriasData.data.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.nombre;
                        categoriaSelect.appendChild(option);
                    });
                }

                // Cargar estados (ciudades)
                const ciudadesRes = await fetch(`${API_URL}/ciudades`);
                const ciudadesData = await ciudadesRes.json();
                const ciudadSelect = document.getElementById('ciudad-select');
                
                if (ciudadesData.success && ciudadesData.data) {
                    ciudadesData.data.forEach(ciudad => {
                        const option = document.createElement('option');
                        option.value = ciudad.id;
                        option.textContent = ciudad.nombre;
                        ciudadSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error cargando datos:', error);
            }
        });

        // Cargar municipios según el estado seleccionado
        async function cargarMunicipios() {
            const estadoId = document.getElementById('ciudad-select').value;
            const municipioSelect = document.getElementById('municipio-select');
            
            municipioSelect.innerHTML = '<option value="">Cargando municipios...</option>';
            
            if (!estadoId) {
                municipioSelect.innerHTML = '<option value="">Primero seleccione un estado...</option>';
                return;
            }

            try {
                const response = await fetch(`${API_URL}/municipios/${estadoId}`);
                const data = await response.json();
                
                municipioSelect.innerHTML = '<option value="">Seleccione un municipio...</option>';
                
                if (data.success && data.data && data.data.length > 0) {
                    data.data.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.id;
                        option.textContent = municipio.nombre;
                        municipioSelect.appendChild(option);
                    });
                } else {
                    municipioSelect.innerHTML = '<option value="">No hay municipios disponibles</option>';
                }
            } catch (error) {
                console.error('Error cargando municipios:', error);
                municipioSelect.innerHTML = '<option value="">Error al cargar municipios</option>';
            }
        }

        // Función para mostrar mensajes
        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            mensaje.className = `mb-4 p-4 rounded-lg ${tipo === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
            mensaje.textContent = texto;
            mensaje.classList.remove('hidden');
            
            setTimeout(() => {
                mensaje.classList.add('hidden');
            }, 5000);
        }

        // Registro de Cliente
        document.getElementById('form-cliente').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            
            // Validar cédula (11 dígitos)
            const cedula = formData.get('cedula');
            const errorCedula = document.getElementById('error-cedula');
            
            if (!/^\d{11}$/.test(cedula)) {
                errorCedula.classList.remove('hidden');
                document.getElementById('cedula-cliente').classList.add('border-red-500');
                notyf.error('❌ La cédula debe tener exactamente 11 dígitos numéricos');
                return;
            }
            
            errorCedula.classList.add('hidden');
            document.getElementById('cedula-cliente').classList.remove('border-red-500');
            
            const data = {
                name: `${formData.get('nombre')} ${formData.get('apellido')}`,
                apellido: formData.get('apellido'),
                cedula: cedula,
                email: formData.get('email'),
                phone: formData.get('telefono'),
                direccion: formData.get('direccion'),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation')
            };

            try {
                const response = await fetch(`${API_URL}/auth/register/cliente`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    // Guardar datos en localStorage
                    localStorage.setItem('auth_token', result.data.access_token);
                    localStorage.setItem('user_role', result.data.user.role.name);
                    localStorage.setItem('user_data', JSON.stringify(result.data.user));
                    
                    mostrarMensaje('✅ ¡Cuenta creada exitosamente! Redirigiendo a tu dashboard...', 'success');
                    setTimeout(() => {
                        window.location.href = '/dashboard/cliente';
                    }, 2000);
                } else {
                    const errores = Object.values(result.errors || {}).flat().join(', ');
                    mostrarMensaje(`❌ Error: ${errores || result.message}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        });

        // Registro de Empresa
        document.getElementById('form-empresa').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            
            // Validar archivo PDF
            const pdfFile = formData.get('documento_rif');
            if (pdfFile && pdfFile.size > 5 * 1024 * 1024) {
                mostrarMensaje('❌ El archivo PDF no debe superar 5MB', 'error');
                return;
            }

            // Preparar FormData con todos los campos
            const submitData = new FormData();
            submitData.append('name', `${formData.get('nombre_responsable')} ${formData.get('apellido_responsable')}`);
            submitData.append('apellido', formData.get('apellido_responsable'));
            submitData.append('email', formData.get('email_empresa'));
            submitData.append('phone', formData.get('telefono_empresa'));
            submitData.append('password', formData.get('password_empresa'));
            submitData.append('password_confirmation', formData.get('password_confirmation_empresa'));
            submitData.append('nombre_comercial', formData.get('nombre_empresa'));
            submitData.append('rfc', formData.get('rif'));
            submitData.append('categoria_id', formData.get('categoria'));
            submitData.append('ciudad_id', formData.get('ciudad'));
            submitData.append('municipio_id', formData.get('municipio'));
            submitData.append('telefono', formData.get('telefono_empresa'));
            submitData.append('email_contacto', formData.get('email_empresa'));
            submitData.append('direccion', formData.get('direccion_empresa'));
            submitData.append('descripcion', formData.get('resena'));
            submitData.append('documento_rif', pdfFile);

            try {
                const response = await fetch(`${API_URL}/auth/register/empresa`, {
                    method: 'POST',
                    body: submitData
                });

                const result = await response.json();

                if (result.success) {
                    // Guardar datos en localStorage
                    localStorage.setItem('auth_token', result.data.access_token);
                    localStorage.setItem('user_role', result.data.user.role.name);
                    localStorage.setItem('user_data', JSON.stringify(result.data.user));
                    localStorage.setItem('empresa_data', JSON.stringify(result.data.empresa));
                    
                    mostrarMensaje('✅ ¡Empresa registrada exitosamente! Redirigiendo a tu dashboard...', 'success');
                    setTimeout(() => {
                        window.location.href = '/dashboard/empresa';
                    }, 2000);
                } else {
                    const errores = Object.values(result.errors || {}).flat().join(', ');
                    mostrarMensaje(`❌ Error: ${errores || result.message}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        });
    </script>

</body>
</html>

