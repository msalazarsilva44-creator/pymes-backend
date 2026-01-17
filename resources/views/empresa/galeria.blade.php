<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería - ServiLocal Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .photo-item {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            aspect-ratio: 1;
        }
        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .photo-item:hover img {
            transform: scale(1.1);
        }
        .photo-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .photo-item:hover .photo-overlay {
            opacity: 1;
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">📸 Galería de Fotos</h1>
            <p class="text-gray-600">Muestra tu trabajo y atrae más clientes con fotos profesionales</p>
        </div>

        <!-- Mensajes -->
        <div id="mensaje" class="hidden mb-6 p-4 rounded-lg"></div>

        <!-- Upload Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Subir Nueva Foto</h2>
            
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-500 transition-colors cursor-pointer" id="upload-area">
                <input type="file" id="file-input" accept="image/*" class="hidden">
                <div class="text-6xl mb-4">📷</div>
                <p class="text-lg font-semibold text-gray-900 mb-2">Click para subir una foto</p>
                <p class="text-sm text-gray-600 mb-4">o arrastra y suelta aquí</p>
                <p class="text-xs text-gray-500">PNG, JPG, JPEG hasta 5MB</p>
            </div>

            <!-- Preview -->
            <div id="preview-section" class="hidden mt-6">
                <div class="flex items-start gap-4">
                    <img id="preview-image" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción (Opcional)
                        </label>
                        <textarea 
                            id="foto-descripcion"
                            rows="3"
                            placeholder="Describe esta foto..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        ></textarea>
                        <div class="flex gap-3 mt-4">
                            <button 
                                onclick="subirFoto()"
                                class="gradient-bg text-white font-semibold py-2 px-6 rounded-lg hover:shadow-lg transition-all"
                            >
                                📤 Subir Foto
                            </button>
                            <button 
                                onclick="cancelarUpload()"
                                class="px-6 py-2 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all"
                            >
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-700 rounded-lg p-6 text-white mb-8">
            <div class="grid grid-cols-3 gap-6 text-center">
                <div>
                    <p class="text-3xl font-bold" id="total-fotos">0</p>
                    <p class="text-purple-100 text-sm">Fotos subidas</p>
                </div>
                <div>
                    <p class="text-3xl font-bold" id="total-vistas">0</p>
                    <p class="text-purple-100 text-sm">Vistas de galería</p>
                </div>
                <div>
                    <p class="text-3xl font-bold">10</p>
                    <p class="text-purple-100 text-sm">Límite de fotos</p>
                </div>
            </div>
        </div>

        <!-- Galería -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Tus Fotos</h2>
            
            <div id="galeria-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <!-- Se llenará dinámicamente -->
                <div class="col-span-full text-center py-12 text-gray-500">
                    <div class="text-6xl mb-4">🖼️</div>
                    <p>No has subido fotos todavía</p>
                    <p class="text-sm mt-2">Las fotos ayudan a los clientes a conocer tu trabajo</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal para ver foto completa -->
    <div id="modal-foto" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="cerrarModal()">
        <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
            <button onclick="cerrarModal()" class="absolute -top-10 right-0 text-white text-3xl hover:text-gray-300">×</button>
            <img id="modal-imagen" src="" alt="" class="w-full rounded-lg">
            <div class="bg-white rounded-b-lg p-4">
                <p id="modal-descripcion" class="text-gray-700"></p>
                <button onclick="eliminarFotoModal()" class="mt-4 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all">
                    🗑️ Eliminar Foto
                </button>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = '';
        let empresaId = null;
        let selectedFile = null;
        let currentPhotoId = null;

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const empresaData = JSON.parse(localStorage.getItem('empresa_data') || '{}');
            const userRole = localStorage.getItem('user_role');

            if (!authToken || userRole !== 'empresa') {
                window.location.href = '/login';
                return;
            }

            empresaId = empresaData.id;
            
            // Cargar galería
            await cargarGaleria();

            // Setup upload area
            setupUploadArea();
        });

        // Setup área de upload
        function setupUploadArea() {
            const uploadArea = document.getElementById('upload-area');
            const fileInput = document.getElementById('file-input');

            uploadArea.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    previewFile(file);
                }
            });

            // Drag & Drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('border-purple-500', 'bg-purple-50');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('border-purple-500', 'bg-purple-50');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('border-purple-500', 'bg-purple-50');
                
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    previewFile(file);
                }
            });
        }

        // Preview de archivo
        function previewFile(file) {
            if (file.size > 5 * 1024 * 1024) {
                mostrarMensaje('❌ La imagen no debe superar 5MB', 'error');
                return;
            }

            selectedFile = file;
            const reader = new FileReader();
            
            reader.onload = (e) => {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-section').classList.remove('hidden');
                document.getElementById('upload-area').classList.add('hidden');
            };
            
            reader.readAsDataURL(file);
        }

        // Cancelar upload
        function cancelarUpload() {
            selectedFile = null;
            document.getElementById('preview-section').classList.add('hidden');
            document.getElementById('upload-area').classList.remove('hidden');
            document.getElementById('file-input').value = '';
            document.getElementById('foto-descripcion').value = '';
        }

        // Subir foto
        async function subirFoto() {
            if (!selectedFile) return;

            const formData = new FormData();
            formData.append('foto', selectedFile);
            formData.append('descripcion', document.getElementById('foto-descripcion').value);

            try {
                mostrarMensaje('⏳ Subiendo foto...', 'info');

                const response = await fetch(`${API_URL}/empresas/${empresaId}/fotos`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    mostrarMensaje('✅ ¡Foto subida exitosamente!', 'success');
                    cancelarUpload();
                    await cargarGaleria();
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al subir la foto'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        }

        // Cargar galería
        async function cargarGaleria() {
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/fotos`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    }
                });

                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    document.getElementById('total-fotos').textContent = result.data.length;
                    
                    const grid = document.getElementById('galeria-grid');
                    grid.innerHTML = result.data.map(foto => `
                        <div class="photo-item" onclick="abrirModal(${foto.id}, '${foto.url}', '${foto.descripcion || ''}')">
                            <img src="${foto.url}" alt="${foto.descripcion || 'Foto de la empresa'}">
                            <div class="photo-overlay">
                                <div class="text-white text-center">
                                    <p class="text-2xl mb-2">👁️</p>
                                    <p class="text-sm">Ver</p>
                                </div>
                            </div>
                        </div>
                    `).join('');
                }
            } catch (error) {
                console.error('Error cargando galería:', error);
            }
        }

        // Abrir modal
        function abrirModal(id, url, descripcion) {
            currentPhotoId = id;
            document.getElementById('modal-imagen').src = url;
            document.getElementById('modal-descripcion').textContent = descripcion || 'Sin descripción';
            document.getElementById('modal-foto').classList.remove('hidden');
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal-foto').classList.add('hidden');
            currentPhotoId = null;
        }

        // Eliminar foto desde modal
        async function eliminarFotoModal() {
            if (!currentPhotoId) return;
            
            if (!confirm('¿Estás seguro de eliminar esta foto?')) return;

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/fotos/${currentPhotoId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`
                    }
                });

                const result = await response.json();

                if (result.success) {
                    mostrarMensaje('✅ Foto eliminada exitosamente', 'success');
                    cerrarModal();
                    await cargarGaleria();
                } else {
                    mostrarMensaje(`❌ ${result.message || 'Error al eliminar la foto'}`, 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión. Intente nuevamente.', 'error');
                console.error('Error:', error);
            }
        }

        // Mostrar mensajes
        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            let bgClass = 'bg-blue-100 text-blue-800 border-blue-200';
            
            if (tipo === 'success') bgClass = 'bg-green-100 text-green-800 border-green-200';
            if (tipo === 'error') bgClass = 'bg-red-100 text-red-800 border-red-200';
            
            mensaje.className = `mb-6 p-4 rounded-lg border ${bgClass}`;
            mensaje.textContent = texto;
            mensaje.classList.remove('hidden');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });

            if (tipo !== 'info') {
                setTimeout(() => {
                    mensaje.classList.add('hidden');
                }, 5000);
            }
        }
    </script>

</body>
</html>

