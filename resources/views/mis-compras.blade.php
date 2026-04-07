<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito - MERCAROF</title>
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
        .main-bg { background-color: #f8fafc; }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/dashboard/cliente" class="text-2xl font-extrabold text-mercarof-navy">MERCAROF</a>
                <div class="flex items-center gap-4">
                    <a href="/dashboard/cliente" class="text-gray-600 hover:text-mercarof-cyan transition-colors font-medium text-sm">
                        ← Seguir comprando
                    </a>
                    <span class="text-sm text-gray-600" id="user-name"></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mi Carrito</h1>
            <p class="text-gray-600">Gestiona tus servicios y realiza tus compras</p>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex">
                    <button onclick="cambiarTab('carrito')" class="tab-btn px-6 py-4 font-semibold border-b-2 border-mercarof-cyan text-mercarof-navy" data-tab="carrito">
                        🛒 Carrito <span id="cart-count-tab" class="ml-1 bg-mercarof-cyan text-white text-xs px-2 py-0.5 rounded-full">0</span>
                    </button>
                    <button onclick="cambiarTab('ordenes')" class="tab-btn px-6 py-4 font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700" data-tab="ordenes">
                        📦 Mis Órdenes
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Carrito -->
        <div id="tab-carrito" class="tab-content">
            <div id="carrito-container">
                <div class="text-center py-12">
                    <div class="animate-spin w-8 h-8 border-4 border-mercarof-cyan border-t-transparent rounded-full mx-auto"></div>
                    <p class="text-gray-500 mt-4">Cargando carrito...</p>
                </div>
            </div>
        </div>

        <!-- Tab Órdenes -->
        <div id="tab-ordenes" class="tab-content hidden">
            <div id="ordenes-container">
                <div class="text-center py-12">
                    <div class="animate-spin w-8 h-8 border-4 border-mercarof-cyan border-t-transparent rounded-full mx-auto"></div>
                    <p class="text-gray-500 mt-4">Cargando órdenes...</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Checkout -->
    <div id="modal-checkout" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">Finalizar Compra</h3>
                    <button onclick="cerrarCheckout()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div id="checkout-empresa-info" class="mb-6"></div>
                
                <!-- Resumen de items -->
                <div id="checkout-items" class="mb-6"></div>
                
                <!-- Métodos de pago -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Método de Pago</label>
                    <div id="metodos-pago-list" class="space-y-2"></div>
                </div>
                
                <!-- Referencia de pago -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Referencia de pago</label>
                    <input type="text" id="referencia-pago" placeholder="Número de referencia o transacción" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent">
                </div>
                
                <!-- Comprobante -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Comprobante de pago (opcional)</label>
                    <input type="file" id="comprobante-pago" accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan">
                    <p class="text-xs text-gray-500 mt-1">Imagen del comprobante (máx. 5MB)</p>
                </div>
                
                <!-- Notas -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notas (opcional)</label>
                    <textarea id="notas-cliente" rows="2" placeholder="Información adicional para la empresa..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan resize-none"></textarea>
                </div>
                
                <!-- Total y botón -->
                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span id="checkout-total" class="text-2xl font-bold text-mercarof-cyan">$0.00</span>
                    </div>
                    <button onclick="procesarOrden()" id="btn-procesar" class="w-full bg-mercarof-navy hover:bg-mercarof-navy-dark text-white font-bold py-4 rounded-xl transition-all">
                        Confirmar Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = '';
        let carritoData = null;
        let checkoutEmpresaId = null;
        let selectedMetodoPago = null;

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const userData = localStorage.getItem('user_data');

            if (!authToken) {
                window.location.href = '/login';
                return;
            }

            if (userData) {
                const user = JSON.parse(userData);
                document.getElementById('user-name').textContent = user.name || 'Cliente';
            }

            await cargarCarrito();
        });

        // Cargar carrito
        async function cargarCarrito() {
            try {
                const response = await fetch(`${API_URL}/carrito`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    carritoData = result.data;
                    renderizarCarrito();
                    document.getElementById('cart-count-tab').textContent = carritoData.total_items;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('carrito-container').innerHTML = `
                    <div class="bg-white rounded-xl p-8 text-center">
                        <p class="text-red-500">Error al cargar el carrito</p>
                    </div>
                `;
            }
        }

        // Renderizar carrito
        function renderizarCarrito() {
            const container = document.getElementById('carrito-container');

            if (!carritoData || carritoData.total_items === 0) {
                container.innerHTML = `
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="text-6xl mb-4">🛒</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tu carrito está vacío</h3>
                        <p class="text-gray-600 mb-6">Explora servicios y productos y agrega lo que necesites</p>
                        <a href="/dashboard/cliente" class="inline-block bg-mercarof-navy text-white font-semibold px-6 py-3 rounded-xl hover:bg-mercarof-navy-dark transition-all">
                            Explorar Servicios
                        </a>
                    </div>
                `;
                return;
            }

            let html = '';
            carritoData.por_empresa.forEach(grupo => {
                html += `
                    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
                        <div class="bg-gradient-to-r from-mercarof-navy to-mercarof-cyan p-4">
                            <div class="flex items-center gap-3">
                                ${grupo.empresa.logo ? `<img src="${grupo.empresa.logo}" class="w-10 h-10 rounded-lg bg-white object-cover">` : '<div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center text-white text-xl">🏢</div>'}
                                <h3 class="text-lg font-bold text-white">${grupo.empresa.nombre_comercial}</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            ${grupo.items.map(item => `
                                <div class="flex items-center justify-between py-3 border-b last:border-0">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">${item.nombre}${item.tipo === 'producto' && item.cantidad > 1 ? ` ×${item.cantidad}` : ''}</h4>
                                        ${item.tipo === 'producto' && item.es_basico ? '<span class="text-[10px] bg-gray-100 text-gray-600 px-1.5 rounded">Básico</span>' : ''}
                                        ${item.descripcion ? `<p class="text-sm text-gray-500">${item.descripcion}</p>` : ''}
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="font-bold text-mercarof-cyan">$${parseFloat(item.precio).toFixed(2)}</span>
                                        <button onclick="eliminarItem(${item.id})" class="text-red-400 hover:text-red-600 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                            <div class="flex justify-between items-center mt-4 pt-4 border-t">
                                <span class="font-semibold text-gray-700">Subtotal:</span>
                                <span class="text-xl font-bold text-gray-900">$${parseFloat(grupo.subtotal).toFixed(2)}</span>
                            </div>
                            <button onclick="abrirCheckout(${grupo.empresa_id})" class="w-full mt-4 bg-mercarof-navy hover:bg-mercarof-navy-dark text-white font-bold py-3 rounded-xl transition-all">
                                Pagar a ${grupo.empresa.nombre_comercial}
                            </button>
                        </div>
                    </div>
                `;
            });

            // Total general
            html += `
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-700">Total General:</span>
                        <span class="text-2xl font-bold text-mercarof-navy">$${parseFloat(carritoData.total).toFixed(2)}</span>
                    </div>
                </div>
            `;

            container.innerHTML = html;
        }

        // Eliminar item del carrito
        async function eliminarItem(itemId) {
            if (!confirm('¿Eliminar este servicio del carrito?')) return;

            try {
                const response = await fetch(`${API_URL}/carrito/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    await cargarCarrito();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Abrir modal de checkout
        async function abrirCheckout(empresaId) {
            checkoutEmpresaId = empresaId;
            const grupo = carritoData.por_empresa.find(g => g.empresa_id === empresaId);
            
            if (!grupo) return;

            // Info empresa
            document.getElementById('checkout-empresa-info').innerHTML = `
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                    ${grupo.empresa.logo ? `<img src="${grupo.empresa.logo}" class="w-12 h-12 rounded-lg object-cover">` : '<div class="w-12 h-12 rounded-lg bg-mercarof-cyan/20 flex items-center justify-center text-2xl">🏢</div>'}
                    <div>
                        <h4 class="font-bold text-gray-900">${grupo.empresa.nombre_comercial}</h4>
                        <p class="text-sm text-gray-500">${grupo.items.length} línea(s) en el pedido</p>
                    </div>
                </div>
            `;

            // Items
            document.getElementById('checkout-items').innerHTML = `
                <div class="space-y-2">
                    ${grupo.items.map(item => `
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">${item.nombre}</span>
                            <span class="font-semibold">$${parseFloat(item.precio).toFixed(2)}</span>
                        </div>
                    `).join('')}
                </div>
            `;

            // Total
            document.getElementById('checkout-total').textContent = `$${parseFloat(grupo.subtotal).toFixed(2)}`;

            // Métodos de pago
            renderizarMetodosPago(grupo.metodos_pago);

            document.getElementById('modal-checkout').classList.remove('hidden');
        }

        // Renderizar métodos de pago
        function renderizarMetodosPago(metodos) {
            const container = document.getElementById('metodos-pago-list');
            
            if (!metodos || metodos.length === 0) {
                container.innerHTML = `
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <p class="text-yellow-800 text-sm">Esta empresa no ha configurado métodos de pago. Contacta directamente para coordinar el pago.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = metodos.map(metodo => `
                <label class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer hover:border-mercarof-cyan transition-colors metodo-pago-option" data-tipo="${metodo.tipo}">
                    <input type="radio" name="metodo_pago" value="${metodo.tipo}" class="mt-1" onchange="seleccionarMetodo('${metodo.tipo}')">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-900">${metodo.datos.icono || '💳'} ${metodo.tipo_nombre}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            ${formatearDatosPago(metodo)}
                        </div>
                    </div>
                </label>
            `).join('');
        }

        // Formatear datos de pago para mostrar
        function formatearDatosPago(metodo) {
            switch(metodo.tipo) {
                case 'paypal':
                    return `<span class="font-mono bg-gray-100 px-2 py-0.5 rounded">${metodo.datos.info}</span>`;
                case 'binance':
                    return `<span class="font-mono bg-gray-100 px-2 py-0.5 rounded">${metodo.datos.info}</span>`;
                case 'transferencia':
                    return `
                        <div class="space-y-1">
                            <p><strong>Banco:</strong> ${metodo.datos.banco}</p>
                            <p><strong>Cuenta:</strong> <span class="font-mono">${metodo.datos.cuenta}</span></p>
                            <p><strong>Titular:</strong> ${metodo.datos.titular}</p>
                            <p><strong>C.I.:</strong> ${metodo.datos.cedula}</p>
                        </div>
                    `;
                case 'pago_movil':
                    return `
                        <div class="space-y-1">
                            <p><strong>Banco:</strong> ${metodo.datos.banco}</p>
                            <p><strong>C.I.:</strong> ${metodo.datos.cedula}</p>
                            <p><strong>Teléfono:</strong> <span class="font-mono">${metodo.datos.telefono}</span></p>
                        </div>
                    `;
                default:
                    return metodo.datos.info || '';
            }
        }

        function seleccionarMetodo(tipo) {
            selectedMetodoPago = tipo;
            document.querySelectorAll('.metodo-pago-option').forEach(el => {
                el.classList.remove('border-mercarof-cyan', 'bg-mercarof-cyan/5');
            });
            document.querySelector(`.metodo-pago-option[data-tipo="${tipo}"]`).classList.add('border-mercarof-cyan', 'bg-mercarof-cyan/5');
        }

        function cerrarCheckout() {
            document.getElementById('modal-checkout').classList.add('hidden');
            checkoutEmpresaId = null;
            selectedMetodoPago = null;
            document.getElementById('referencia-pago').value = '';
            document.getElementById('comprobante-pago').value = '';
            document.getElementById('notas-cliente').value = '';
        }

        // Procesar orden
        async function procesarOrden() {
            if (!selectedMetodoPago) {
                alert('Selecciona un método de pago');
                return;
            }

            const btn = document.getElementById('btn-procesar');
            btn.disabled = true;
            btn.textContent = 'Procesando...';

            try {
                const formData = new FormData();
                formData.append('empresa_id', checkoutEmpresaId);
                formData.append('metodo_pago', selectedMetodoPago);
                formData.append('referencia_pago', document.getElementById('referencia-pago').value);
                formData.append('notas_cliente', document.getElementById('notas-cliente').value);
                
                const comprobante = document.getElementById('comprobante-pago').files[0];
                if (comprobante) {
                    formData.append('comprobante_pago', comprobante);
                }

                const response = await fetch(`${API_URL}/ordenes`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ Orden creada exitosamente. Número: ' + result.data.numero_orden);
                    cerrarCheckout();
                    await cargarCarrito();
                    cambiarTab('ordenes');
                    await cargarOrdenes();
                } else {
                    alert(result.message || 'Error al crear la orden');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar la orden');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Confirmar Pedido';
            }
        }

        // Cargar órdenes
        async function cargarOrdenes() {
            try {
                const response = await fetch(`${API_URL}/mis-ordenes`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    renderizarOrdenes(result.data);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Renderizar órdenes
        function renderizarOrdenes(ordenes) {
            const container = document.getElementById('ordenes-container');

            if (!ordenes || ordenes.length === 0) {
                container.innerHTML = `
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="text-6xl mb-4">📦</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No tienes órdenes</h3>
                        <p class="text-gray-600">Tus pedidos aparecerán aquí</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = ordenes.map(orden => `
                <div class="bg-white rounded-xl shadow-sm mb-4 overflow-hidden">
                    <div class="p-4 border-b flex justify-between items-center">
                        <div>
                            <span class="font-mono text-sm text-gray-500">${orden.numero_orden}</span>
                            <h4 class="font-bold text-gray-900">${orden.empresa?.nombre_comercial || 'Empresa'}</h4>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold ${getEstadoClasses(orden.estado)}">
                            ${getEstadoLabel(orden.estado)}
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2 mb-4">
                            ${orden.items.map(item => `
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">${item.nombre_servicio}${item.cantidad > 1 ? ` ×${item.cantidad}` : ''}</span>
                                    <span class="font-semibold">$${parseFloat(item.precio).toFixed(2)}</span>
                                </div>
                            `).join('')}
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t">
                            <span class="text-sm text-gray-500">${new Date(orden.created_at).toLocaleDateString('es-ES')}</span>
                            <span class="font-bold text-lg text-mercarof-navy">$${parseFloat(orden.total).toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function getEstadoClasses(estado) {
            const classes = {
                'pendiente': 'bg-yellow-100 text-yellow-800',
                'pagado': 'bg-blue-100 text-blue-800',
                'confirmado': 'bg-cyan-100 text-cyan-800',
                'completado': 'bg-green-100 text-green-800',
                'cancelado': 'bg-red-100 text-red-800',
            };
            return classes[estado] || 'bg-gray-100 text-gray-800';
        }

        function getEstadoLabel(estado) {
            const labels = {
                'pendiente': '⏳ Pendiente',
                'pagado': '💳 Pagado',
                'confirmado': '✓ Confirmado',
                'completado': '✅ Completado',
                'cancelado': '❌ Cancelado',
            };
            return labels[estado] || estado;
        }

        // Cambiar tabs
        function cambiarTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-mercarof-cyan', 'text-mercarof-navy');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            document.getElementById(`tab-${tab}`).classList.remove('hidden');
            
            const btnActivo = document.querySelector(`[data-tab="${tab}"]`);
            if (btnActivo) {
                btnActivo.classList.remove('border-transparent', 'text-gray-500');
                btnActivo.classList.add('border-mercarof-cyan', 'text-mercarof-navy');
            }

            if (tab === 'ordenes') {
                cargarOrdenes();
            }
        }
    </script>

</body>
</html>
