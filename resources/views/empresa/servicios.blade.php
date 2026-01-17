<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - ServiLocal Empresa</title>
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
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">💼 Servicios que Ofreces</h1>
            <p class="text-gray-600">Lista los servicios de tu empresa para que los clientes sepan qué ofreces</p>
        </div>

        <!-- Mensajes -->
        <div id="mensaje" class="hidden mb-6 p-4 rounded-lg"></div>

        <!-- Agregar Servicio -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">➕ Agregar Nuevo Servicio</h2>
            
            <form id="form-servicio" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Servicio *
                        </label>
                        <input 
                            type="text" 
                            name="nombre" 
                            id="nombre"
                            required
                            placeholder="Ej: Reparación de fugas"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Precio (Opcional)
                        </label>
                        <input 
                            type="text" 
                            name="precio" 
                            id="precio"
                            placeholder="Ej: $50 o A consultar"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción del Servicio
                    </label>
                    <textarea 
                        name="descripcion" 
                        id="descripcion"
                        rows="3"
                        placeholder="Describe en qué consiste este servicio..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    ></textarea>
                </div>

                <button 
                    type="submit"
                    class="gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all"
                >
                    ➕ Agregar Servicio
                </button>
            </form>
        </div>

        <!-- Lista de Servicios -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Tus Servicios</h2>
            
            <div id="lista-servicios" class="space-y-4">
                <!-- Se llenará dinámicamente -->
                <div class="text-center py-12 text-gray-500">
                    <div class="text-6xl mb-4">📋</div>
                    <p>No has agregado servicios todavía</p>
                    <p class="text-sm mt-2">Agrega los servicios que ofreces para atraer más clientes</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Editar Servicio -->
    <div id="modal-editar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">✏️ Editar Servicio</h2>
                <button onclick="cerrarModal()" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
            </div>

            <form id="form-editar" class="space-y-4">
                <input type="hidden" id="edit-id">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Servicio *</label>
                    <input 
                        type="text" 
                        id="edit-nombre"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio</label>
                    <input 
                        type="text" 
                        id="edit-precio"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea 
                        id="edit-descripcion"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    ></textarea>
                </div>

                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="flex-1 gradient-bg text-white font-semibold py-3 rounded-lg hover:shadow-lg transition-all"
                    >
                        💾 Guardar Cambios
                    </button>
                    <button 
                        type="button"
                        onclick="cerrarModal()"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all"
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
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
            
            // Cargar servicios
            await cargarServicios();
        });

        // Agregar servicio
        document.getElementById('form-servicio').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            
            const data = {
                nombre: formData.get('nombre'),
                precio: formData.get('precio'),
                descripcion: formData.get('descripcion')
            };

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/servicios`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    mostrarMensaje('✅ ¡Servicio agregado exitosamente!', 'success');
                    e.target.reset();
                    await cargarServicios();
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al agregar el servicio'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        });

        // Cargar servicios
        async function cargarServicios() {
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/servicios`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    }
                });

                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    const lista = document.getElementById('lista-servicios');
                    lista.innerHTML = result.data.map(servicio => `
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-2">
                                        <h3 class="font-bold text-lg text-gray-900">${servicio.nombre}</h3>
                                        ${servicio.precio ? `<span class="text-purple-600 font-semibold text-lg">${servicio.precio}</span>` : ''}
                                    </div>
                                    ${servicio.descripcion ? `<p class="text-gray-600 text-sm mb-3">${servicio.descripcion}</p>` : ''}
                                    <div class="flex gap-2">
                                        <button 
                                            onclick="editarServicio(${servicio.id}, '${servicio.nombre.replace(/'/g, "\\'")}', '${servicio.precio || ''}', '${(servicio.descripcion || '').replace(/'/g, "\\'")}')"
                                            class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-lg hover:bg-blue-200 transition-all font-medium"
                                        >
                                            ✏️ Editar
                                        </button>
                                        <button 
                                            onclick="eliminarServicio(${servicio.id})"
                                            class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded-lg hover:bg-red-200 transition-all font-medium"
                                        >
                                            🗑️ Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('');
                }
            } catch (error) {
                console.error('Error cargando servicios:', error);
            }
        }

        // Editar servicio
        function editarServicio(id, nombre, precio, descripcion) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-precio').value = precio;
            document.getElementById('edit-descripcion').value = descripcion;
            document.getElementById('modal-editar').classList.remove('hidden');
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal-editar').classList.add('hidden');
            document.getElementById('form-editar').reset();
        }

        // Guardar edición
        document.getElementById('form-editar').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const id = document.getElementById('edit-id').value;
            const data = {
                nombre: document.getElementById('edit-nombre').value,
                precio: document.getElementById('edit-precio').value,
                descripcion: document.getElementById('edit-descripcion').value
            };

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/servicios/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    mostrarMensaje('✅ ¡Servicio actualizado exitosamente!', 'success');
                    cerrarModal();
                    await cargarServicios();
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al actualizar el servicio'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        });

        // Eliminar servicio
        async function eliminarServicio(id) {
            if (!confirm('¿Estás seguro de eliminar este servicio?')) return;

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/servicios/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    }
                });

                const result = await response.json();

                if (result.success) {
                    mostrarMensaje('✅ Servicio eliminado exitosamente', 'success');
                    await cargarServicios();
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al eliminar el servicio'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        }

        // Mostrar mensajes
        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            let bgClass = 'bg-green-100 text-green-800 border-green-200';
            
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

