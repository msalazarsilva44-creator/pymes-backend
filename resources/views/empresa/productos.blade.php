<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - MERCAROF Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'mercarof-navy': '#003B5C',
                        'mercarof-navy-dark': '#002942',
                        'mercarof-cyan': '#00A3E0',
                        'mercarof-cyan-dark': '#0082B8',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #003B5C 0%, #00A3E0 100%); }
        .main-bg { background-color: #f3f4f6; }
    </style>
</head>
<body class="main-bg">

    <header class="bg-white shadow-md border-b-2 border-mercarof-cyan border-opacity-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="/dashboard/empresa" class="text-2xl font-bold text-mercarof-navy">MERCAROF</a>
                <a href="/dashboard/empresa" class="text-gray-600 hover:text-mercarof-cyan transition-colors font-medium">← Volver al Dashboard</a>
            </div>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">📦 Productos</h1>
            <p class="text-gray-600">Precio, descripción, stock, línea básica y hasta <strong>5 imágenes</strong> por producto (JPEG/PNG/WebP, máx. 5 MB c/u).</p>
        </div>

        <div id="mensaje" class="hidden mb-6 p-4 rounded-lg"></div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">➕ Agregar producto</h2>
            <form id="form-producto" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" required placeholder="Ej: Kit de herramientas"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Precio (USD) *</label>
                        <input type="number" name="precio" id="precio" required min="0" step="0.01" placeholder="0.00"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad en stock *</label>
                        <input type="number" name="cantidad" id="cantidad" required min="0" step="1" value="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                    </div>
                    <div class="flex items-end pb-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="es_basico" id="es_basico" checked class="rounded border-gray-300 text-mercarof-cyan focus:ring-mercarof-cyan">
                            <span class="text-sm text-gray-700">Producto de línea <strong>básica</strong> (visible en catálogo con insignia)</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" placeholder="Detalle del producto..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent"></textarea>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">📷 Imágenes del producto <span class="text-gray-400 font-normal">(opcional, hasta 5)</span></label>
                    <input type="file" id="nuevo-imagenes" multiple accept="image/jpeg,image/png,image/gif,image/webp"
                           class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-mercarof-navy file:text-white file:font-medium hover:file:bg-mercarof-navy-dark">
                    <p class="text-xs text-gray-500 mt-2">JPEG, PNG, GIF o WebP. Máx. 5 archivos y 5 MB c/u.</p>
                </div>
                <button type="submit" class="gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all">
                    ➕ Agregar producto
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Tus productos</h2>
            <div id="lista-productos" class="space-y-4">
                <div class="text-center py-12 text-gray-500">
                    <div class="text-6xl mb-4">📦</div>
                    <p>No has agregado productos todavía</p>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-editar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4" onclick="if(event.target===this) cerrarModal()">
        <div class="bg-white rounded-xl max-w-2xl w-full p-6 max-h-[92vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">✏️ Editar producto</h2>
                <button type="button" onclick="cerrarModal()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>
            <form id="form-editar" class="space-y-4">
                <input type="hidden" id="edit-id">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                    <input type="text" id="edit-nombre" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Precio *</label>
                        <input type="number" id="edit-precio" required min="0" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                        <input type="number" id="edit-cantidad" required min="0" step="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea id="edit-descripcion" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mercarof-cyan"></textarea>
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="edit-es-basico" class="rounded border-gray-300 text-mercarof-cyan focus:ring-mercarof-cyan">
                    <span class="text-sm text-gray-700">Línea básica</span>
                </label>

                <div class="border-t border-gray-200 pt-4 mt-2">
                    <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">📷 Fotos <span id="modal-fotos-count" class="text-xs font-normal text-gray-500">(0/5)</span></h3>
                    <div id="modal-fotos-grid" class="grid grid-cols-5 gap-2 mb-3 min-h-[72px]"></div>
                    <div id="modal-fotos-upload-wrap" class="hidden">
                        <input type="file" id="modal-file-prod" accept="image/jpeg,image/png,image/gif,image/webp" class="text-sm text-gray-600 file:mr-2 file:py-1.5 file:px-2 file:rounded file:border-0 file:bg-emerald-600 file:text-white w-full">
                        <button type="button" onclick="subirImagenDesdeModal()" class="mt-2 w-full sm:w-auto text-sm bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg">⬆ Subir imagen</button>
                    </div>
                    <p id="modal-fotos-limite" class="text-xs text-gray-400 mt-2 hidden">Has alcanzado el máximo de 5 imágenes.</p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 gradient-bg text-white font-semibold py-3 rounded-lg hover:shadow-lg transition-all">💾 Guardar datos</button>
                    <button type="button" onclick="cerrarModal()" class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50">Cerrar</button>
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
            await cargarProductos();
        });

        document.getElementById('form-producto').addEventListener('submit', async (e) => {
            e.preventDefault();
            const filesInput = document.getElementById('nuevo-imagenes');
            if (filesInput.files && filesInput.files.length > 5) {
                mostrarMensaje('Máximo 5 imágenes al crear el producto', 'error');
                return;
            }

            const data = {
                nombre: document.getElementById('nombre').value,
                descripcion: document.getElementById('descripcion').value || null,
                precio: parseFloat(document.getElementById('precio').value),
                cantidad: parseInt(document.getElementById('cantidad').value, 10),
                es_basico: document.getElementById('es_basico').checked
            };

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/productos`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    const nuevoId = result.data.id;
                    const files = filesInput.files;
                    if (files && files.length > 0) {
                        let subidas = 0;
                        for (let i = 0; i < Math.min(files.length, 5); i++) {
                            const fd = new FormData();
                            fd.append('imagen', files[i]);
                            const up = await fetch(`${API_URL}/empresas/${empresaId}/productos/${nuevoId}/imagenes`, {
                                method: 'POST',
                                headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' },
                                body: fd
                            });
                            const jr = await up.json();
                            if (jr.success) subidas++;
                        }
                        mostrarMensaje(`✅ Producto agregado${subidas ? ' · ' + subidas + ' imagen(es)' : ''}`, 'success');
                    } else {
                        mostrarMensaje('✅ Producto agregado', 'success');
                    }
                    e.target.reset();
                    document.getElementById('es_basico').checked = true;
                    filesInput.value = '';
                    await cargarProductos();
                } else {
                    mostrarMensaje(result.message || (result.errors ? JSON.stringify(result.errors) : 'Error'), 'error');
                }
            } catch (error) {
                mostrarMensaje('❌ Error de conexión', 'error');
            }
        });

        function escapeHtml(text) {
            if (!text) return '';
            const d = document.createElement('div');
            d.textContent = text;
            return d.innerHTML;
        }

        async function subirImagenDesdeModal() {
            const productoId = document.getElementById('edit-id').value;
            const input = document.getElementById('modal-file-prod');
            if (!productoId || !input.files || !input.files[0]) {
                mostrarMensaje('Selecciona una imagen', 'error');
                return;
            }
            const fd = new FormData();
            fd.append('imagen', input.files[0]);
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/productos/${productoId}/imagenes`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    },
                    body: fd
                });
                const result = await response.json();
                if (result.success) {
                    input.value = '';
                    await refrescarFotosModal(parseInt(productoId, 10));
                    await cargarProductos();
                } else {
                    mostrarMensaje(result.message || 'No se pudo subir', 'error');
                }
            } catch (e) {
                mostrarMensaje('❌ Error de red', 'error');
            }
        }

        async function refrescarFotosModal(productoId) {
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/productos`, {
                    headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' }
                });
                const result = await response.json();
                if (result.success && Array.isArray(result.data)) {
                    const p = result.data.find(x => Number(x.id) === Number(productoId));
                    if (p) renderImagenesModal(p);
                }
            } catch (e) {}
        }

        function renderImagenesModal(p) {
            const imgs = p.imagenes || [];
            const n = imgs.length;
            document.getElementById('modal-fotos-count').textContent = '(' + n + '/5)';
            const grid = document.getElementById('modal-fotos-grid');
            grid.innerHTML = imgs.map(im => `
                <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                    <img src="${im.url}" alt="" class="w-full h-full object-cover">
                    <button type="button" onclick="eliminarImagenModal(${im.id})"
                        class="absolute top-1 right-1 w-7 h-7 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-full shadow-md" title="Quitar foto">×</button>
                </div>
            `).join('');
            const wrap = document.getElementById('modal-fotos-upload-wrap');
            const lim = document.getElementById('modal-fotos-limite');
            if (n < 5) {
                wrap.classList.remove('hidden');
                lim.classList.add('hidden');
            } else {
                wrap.classList.add('hidden');
                lim.classList.remove('hidden');
            }
        }

        async function eliminarImagenModal(imagenId) {
            const productoId = parseInt(document.getElementById('edit-id').value, 10);
            if (!productoId) return;
            if (!confirm('¿Quitar esta imagen?')) return;
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/productos/${productoId}/imagenes/${imagenId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    await refrescarFotosModal(productoId);
                    await cargarProductos();
                } else {
                    mostrarMensaje('No se pudo eliminar', 'error');
                }
            } catch (e) {
                mostrarMensaje('Error de red', 'error');
            }
        }

        async function cargarProductos() {
            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/productos`, {
                    headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' }
                });
                const result = await response.json();

                const lista = document.getElementById('lista-productos');
                if (result.success && result.data.length > 0) {
                    lista.innerHTML = result.data.map(p => {
                        const imgs = p.imagenes || [];
                        const nImg = imgs.length;
                        const thumbs = nImg === 0
                            ? `<div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-2xl text-gray-400 shrink-0" title="Sin fotos">📷</div>`
                            : `<div class="flex gap-1.5 shrink-0 items-center">
                                ${imgs.slice(0, 3).map(im => `<img src="${im.url}" alt="" class="w-16 h-16 rounded-xl object-cover border border-gray-200 shadow-sm">`).join('')}
                                ${nImg > 3 ? `<span class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-sm font-bold text-gray-600">+${nImg - 3}</span>` : ''}
                               </div>`;
                        return `
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all flex flex-col sm:flex-row gap-4 items-start">
                            ${thumbs}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h3 class="font-bold text-lg text-gray-900">${escapeHtml(p.nombre)}</h3>
                                    ${p.es_basico ? '<span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full font-semibold">Básico</span>' : ''}
                                    <span class="text-xs text-gray-400">${nImg}/5 fotos</span>
                                </div>
                                <p class="text-mercarof-navy font-bold">$${parseFloat(p.precio).toFixed(2)}</p>
                                <p class="text-sm text-gray-500">Stock: <strong>${p.cantidad}</strong></p>
                                ${p.descripcion ? `<p class="text-gray-600 text-sm mt-1 line-clamp-2">${escapeHtml(p.descripcion)}</p>` : ''}
                                <div class="flex flex-wrap gap-2 mt-3">
                                    <button type="button" onclick="abrirEditar(${p.id})" class="text-sm bg-mercarof-navy text-white px-4 py-2 rounded-lg hover:bg-mercarof-navy-dark font-medium">✏️ Editar y fotos</button>
                                    <button type="button" onclick="eliminarProducto(${p.id})" class="text-sm bg-red-50 text-red-700 px-3 py-2 rounded-lg hover:bg-red-100 font-medium">🗑️ Eliminar</button>
                                </div>
                            </div>
                        </div>
                    `;
                    }).join('');
                } else {
                    lista.innerHTML = `
                        <div class="text-center py-12 text-gray-500">
                            <div class="text-6xl mb-4">📦</div>
                            <p>No has agregado productos todavía</p>
                        </div>`;
                }
            } catch (error) {
                console.error(error);
            }
        }

        function abrirEditar(id) {
            fetch(`${API_URL}/empresas/${empresaId}/productos`, {
                headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' }
            }).then(r => r.json()).then(result => {
                const p = result.data.find(x => Number(x.id) === Number(id));
                if (!p) return;
                document.getElementById('edit-id').value = p.id;
                document.getElementById('edit-nombre').value = p.nombre;
                document.getElementById('edit-precio').value = p.precio;
                document.getElementById('edit-cantidad').value = p.cantidad;
                document.getElementById('edit-descripcion').value = p.descripcion || '';
                document.getElementById('edit-es-basico').checked = !!p.es_basico;
                renderImagenesModal(p);
                document.getElementById('modal-file-prod').value = '';
                const modal = document.getElementById('modal-editar');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        }

        function cerrarModal() {
            const modal = document.getElementById('modal-editar');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('form-editar').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('edit-id').value;
            const data = {
                nombre: document.getElementById('edit-nombre').value,
                precio: parseFloat(document.getElementById('edit-precio').value),
                cantidad: parseInt(document.getElementById('edit-cantidad').value, 10),
                descripcion: document.getElementById('edit-descripcion').value || null,
                es_basico: document.getElementById('edit-es-basico').checked
            };

            const response = await fetch(`${API_URL}/empresas/${empresaId}/productos/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                mostrarMensaje('✅ Datos guardados', 'success');
                await refrescarFotosModal(parseInt(id, 10));
                await cargarProductos();
            } else {
                mostrarMensaje('❌ Error al guardar', 'error');
            }
        });

        async function eliminarProducto(id) {
            if (!confirm('¿Eliminar este producto?')) return;
            const response = await fetch(`${API_URL}/empresas/${empresaId}/productos/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            if (result.success) {
                const editId = document.getElementById('edit-id').value;
                if (editId && Number(editId) === Number(id)) cerrarModal();
                mostrarMensaje('✅ Eliminado', 'success');
                await cargarProductos();
            }
        }

        function mostrarMensaje(texto, tipo) {
            const mensaje = document.getElementById('mensaje');
            mensaje.className = tipo === 'error'
                ? 'mb-6 p-4 rounded-lg border bg-red-100 text-red-800 border-red-200'
                : 'mb-6 p-4 rounded-lg border bg-green-100 text-green-800 border-green-200';
            mensaje.textContent = texto;
            mensaje.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => mensaje.classList.add('hidden'), 5000);
        }
    </script>
</body>
</html>
