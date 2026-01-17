<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Plan - ServiLocal Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
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
        
        /* Personalizar Notyf */
        .notyf__toast {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .notyf__toast--success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .notyf__toast--error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        /* Estilos para pestañas de métodos de pago */
        .tab-button {
            background: #f3f4f6;
            color: #6b7280;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
        }
        
        .tab-button:hover {
            background: #e5e7eb;
        }
        
        .tab-button.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-bottom-color: #764ba2;
        }

        .metodo-content {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">💳 Solicitar Plan de Suscripción</h1>
            <p class="text-gray-600">Mejora tu visibilidad con un plan Básico o Premium</p>
        </div>

        <!-- Formulario -->
        <form id="form-suscripcion" class="space-y-6">
            
            <!-- Seleccionar Plan -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">📋 Seleccionar Plan</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Plan *</label>
                    <select 
                        id="plan_id" 
                        name="plan_id"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >
                        <option value="">-- Selecciona un plan --</option>
                        <!-- Se llenará dinámicamente -->
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periodo de Pago *</label>
                    <select 
                        id="tipo_periodo" 
                        name="tipo_periodo"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >
                        <option value="">-- Selecciona el periodo --</option>
                        <option value="mensual">Mensual</option>
                        <option value="anual">Anual (¡Ahorra dinero!)</option>
                    </select>
                </div>

                <div id="precio-container" class="hidden bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Total a Pagar:</p>
                        <p class="text-3xl font-bold text-green-600" id="precio-total">$0.00</p>
                    </div>
                </div>
            </div>

            <!-- Selector de Método de Pago -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">💳 Selecciona tu Método de Pago</h2>
                
                <!-- Pestañas -->
                <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 pb-2">
                    <button type="button" onclick="cambiarMetodoPago('banco')" 
                            id="tab-banco" 
                            class="tab-button active px-6 py-3 font-semibold rounded-t-lg flex-1 sm:flex-none">
                        🏦 Banco
                    </button>
                    <button type="button" onclick="cambiarMetodoPago('binance')" 
                            id="tab-binance" 
                            class="tab-button px-6 py-3 font-semibold rounded-t-lg flex-1 sm:flex-none">
                        ₿ Binance
                    </button>
                    <button type="button" onclick="cambiarMetodoPago('paypal')" 
                            id="tab-paypal" 
                            class="tab-button px-6 py-3 font-semibold rounded-t-lg flex-1 sm:flex-none">
                        💵 PayPal
                    </button>
                    <button type="button" onclick="cambiarMetodoPago('zelle')" 
                            id="tab-zelle" 
                            class="tab-button px-6 py-3 font-semibold rounded-t-lg flex-1 sm:flex-none">
                        💸 Zelle
                    </button>
                </div>

                <!-- Campo oculto para guardar método seleccionado -->
                <input type="hidden" id="metodo_pago" name="metodo_pago" value="banco">

                <!-- Contenido: Banco -->
                <div id="content-banco" class="metodo-content">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-500 p-6 rounded-lg">
                        <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <span class="text-2xl">🏦</span>
                            Transferencia Bancaria
                        </h3>
                        <div class="space-y-2 text-blue-800">
                            <p><strong>Banco:</strong> Banco Provincial</p>
                            <p><strong>Tipo:</strong> Cuenta Corriente</p>
                            <p><strong>Número de Cuenta:</strong> 0108-1234-56789-0001234</p>
                            <p><strong>RIF:</strong> J-12345678-9</p>
                            <p><strong>Titular:</strong> ServiLocal C.A.</p>
                        </div>
                        <div class="mt-4 bg-white/70 p-3 rounded-lg">
                            <p class="text-sm text-blue-700">
                                💡 <strong>Instrucciones:</strong> Realiza la transferencia bancaria y sube el comprobante en el formulario de abajo.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido: Binance -->
                <div id="content-binance" class="metodo-content hidden">
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 p-6 rounded-lg">
                        <h3 class="text-lg font-bold text-yellow-900 mb-4 flex items-center gap-2">
                            <span class="text-2xl">₿</span>
                            Binance Pay
                        </h3>
                        <div class="space-y-2 text-yellow-800">
                            <p><strong>Binance ID:</strong> 123456789</p>
                            <p><strong>Email Binance:</strong> pagos@servilocal.com</p>
                            <p><strong>Criptomonedas Aceptadas:</strong> USDT, BTC, BNB</p>
                        </div>
                        <div class="mt-4 bg-white/70 p-3 rounded-lg">
                            <p class="text-sm text-yellow-700">
                                💡 <strong>Instrucciones:</strong> Envía el pago vía Binance Pay y captura la pantalla de la transacción confirmada.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido: PayPal -->
                <div id="content-paypal" class="metodo-content hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 border-l-4 border-indigo-500 p-6 rounded-lg">
                        <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center gap-2">
                            <span class="text-2xl">💵</span>
                            PayPal
                        </h3>
                        <div class="space-y-2 text-indigo-800">
                            <p><strong>Email PayPal:</strong> pagos@servilocal.com</p>
                            <p><strong>Tipo de Cuenta:</strong> Cuenta de Negocios</p>
                            <p><strong>Nombre:</strong> ServiLocal</p>
                        </div>
                        <div class="mt-4 bg-white/70 p-3 rounded-lg">
                            <p class="text-sm text-indigo-700">
                                💡 <strong>Instrucciones:</strong> Envía el pago a este email de PayPal y captura la confirmación de la transacción.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido: Zelle -->
                <div id="content-zelle" class="metodo-content hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 border-l-4 border-purple-500 p-6 rounded-lg">
                        <h3 class="text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                            <span class="text-2xl">💸</span>
                            Zelle
                        </h3>
                        <div class="space-y-2 text-purple-800">
                            <p><strong>Email Zelle:</strong> pagos@servilocal.com</p>
                            <p><strong>Nombre Registrado:</strong> ServiLocal LLC</p>
                            <p><strong>País:</strong> Estados Unidos</p>
                        </div>
                        <div class="mt-4 bg-white/70 p-3 rounded-lg">
                            <p class="text-sm text-purple-700">
                                💡 <strong>Instrucciones:</strong> Envía el pago vía Zelle y captura el comprobante de la transacción.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Pago -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">💰 Información de Pago</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre del Pagador *</label>
                        <input 
                            type="text" 
                            id="nombre_empresa_pagadora" 
                            name="nombre_empresa_pagadora"
                            required
                            placeholder="Empresa o Persona que realizó el pago"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RIF del Pagador *</label>
                        <input 
                            type="text" 
                            id="rif_pagador" 
                            name="rif_pagador"
                            required
                            placeholder="Ej: J-12345678-9"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>

                    <div>
                        <label id="label-referencia" class="block text-sm font-semibold text-gray-700 mb-2">Referencia Bancaria *</label>
                        <input 
                            type="text" 
                            id="referencia_bancaria" 
                            name="referencia_bancaria"
                            required
                            placeholder="Últimos 4-10 dígitos"
                            maxlength="50"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Pago *</label>
                        <input 
                            type="date" 
                            id="fecha_pago" 
                            name="fecha_pago"
                            required
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Capture de Pago *</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="capture_pago" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Haz clic para subir</span> o arrastra y suelta</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF (MÁX. 5MB)</p>
                            </div>
                            <input 
                                id="capture_pago" 
                                name="capture_pago"
                                type="file" 
                                class="hidden" 
                                accept="image/*"
                                required
                            />
                        </label>
                    </div>
                    <div id="preview-capture" class="mt-4 hidden">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Vista previa:</p>
                        <img id="img-preview" src="" alt="Preview" class="max-w-full h-auto rounded-lg border-2 border-gray-300">
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex gap-4">
                    <button 
                        type="submit"
                        id="btn-submit"
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg transition-all"
                    >
                        Enviar Solicitud
                    </button>
                    <a 
                        href="/dashboard/empresa"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-3 rounded-lg transition-all text-center"
                    >
                        Cancelar
                    </a>
                </div>
            </div>

        </form>

    </div>

    <!-- Notyf JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        // Inicializar Notyf
        const notyf = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' },
            dismissible: true
        });

        const API_URL = 'http://localhost:8000/api';
        let planes = [];

        // Función para cambiar método de pago
        function cambiarMetodoPago(metodo) {
            // Actualizar pestañas activas
            document.querySelectorAll('.tab-button').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById('tab-' + metodo).classList.add('active');
            
            // Mostrar contenido correspondiente
            document.querySelectorAll('.metodo-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('content-' + metodo).classList.remove('hidden');
            
            // Guardar método seleccionado
            document.getElementById('metodo_pago').value = metodo;
            
            // Actualizar label y placeholder de referencia según método
            const labelReferencia = document.getElementById('label-referencia');
            const inputReferencia = document.getElementById('referencia_bancaria');
            
            switch(metodo) {
                case 'banco':
                    labelReferencia.textContent = 'Referencia Bancaria *';
                    inputReferencia.placeholder = 'Últimos 4-10 dígitos';
                    break;
                case 'binance':
                    labelReferencia.textContent = 'Transaction ID (Binance) *';
                    inputReferencia.placeholder = 'ID de transacción de Binance';
                    break;
                case 'paypal':
                    labelReferencia.textContent = 'Transaction ID (PayPal) *';
                    inputReferencia.placeholder = 'ID de transacción de PayPal';
                    break;
                case 'zelle':
                    labelReferencia.textContent = 'Confirmation Code (Zelle) *';
                    inputReferencia.placeholder = 'Código de confirmación de Zelle';
                    break;
            }
        }

        // Cargar planes
        async function cargarPlanes() {
            try {
                const response = await fetch(`${API_URL}/planes`);
                const data = await response.json();
                
                if (data.success) {
                    // Filtrar solo planes de pago (no gratis)
                    planes = data.data.filter(plan => plan.slug !== 'gratis');
                    
                    const select = document.getElementById('plan_id');
                    select.innerHTML = '<option value="">-- Selecciona un plan --</option>';
                    
                    planes.forEach(plan => {
                        const option = document.createElement('option');
                        option.value = plan.id;
                        option.textContent = plan.nombre;
                        option.dataset.precioMensual = plan.precio_mensual;
                        option.dataset.precioAnual = plan.precio_anual;
                        select.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error cargando planes:', error);
                notyf.error('Error al cargar los planes');
            }
        }

        // Calcular precio
        function calcularPrecio() {
            const planSelect = document.getElementById('plan_id');
            const periodoSelect = document.getElementById('tipo_periodo');
            const precioContainer = document.getElementById('precio-container');
            const precioTotal = document.getElementById('precio-total');

            if (planSelect.value && periodoSelect.value) {
                const option = planSelect.options[planSelect.selectedIndex];
                const precio = periodoSelect.value === 'mensual' 
                    ? option.dataset.precioMensual 
                    : option.dataset.precioAnual;

                precioTotal.textContent = `$${parseFloat(precio).toFixed(2)}`;
                precioContainer.classList.remove('hidden');
            } else {
                precioContainer.classList.add('hidden');
            }
        }

        // Preview de imagen
        document.getElementById('capture_pago').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('img-preview').src = e.target.result;
                    document.getElementById('preview-capture').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Event listeners
        document.getElementById('plan_id').addEventListener('change', calcularPrecio);
        document.getElementById('tipo_periodo').addEventListener('change', calcularPrecio);

        // Enviar formulario
        document.getElementById('form-suscripcion').addEventListener('submit', async function(e) {
            e.preventDefault();

            const token = localStorage.getItem('auth_token'); // Corregido: usar 'auth_token'
            if (!token) {
                notyf.error('Debes iniciar sesión');
                window.location.href = '/login'; // Redirigir al login
                return;
            }

            const btnSubmit = document.getElementById('btn-submit');
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Enviando...';

            const formData = new FormData();
            formData.append('plan_id', document.getElementById('plan_id').value);
            formData.append('tipo_periodo', document.getElementById('tipo_periodo').value);
            formData.append('metodo_pago', document.getElementById('metodo_pago').value); // NUEVO
            formData.append('nombre_empresa_pagadora', document.getElementById('nombre_empresa_pagadora').value);
            formData.append('rif_pagador', document.getElementById('rif_pagador').value);
            formData.append('referencia_bancaria', document.getElementById('referencia_bancaria').value);
            formData.append('fecha_pago', document.getElementById('fecha_pago').value);
            
            const captureFile = document.getElementById('capture_pago').files[0];
            if (captureFile) {
                formData.append('capture_pago', captureFile);
            }

            try {
                const response = await fetch(`${API_URL}/suscripciones/solicitar`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();
                
                // Debug: mostrar respuesta completa en consola
                console.log('Respuesta del servidor:', data);
                console.log('Status:', response.status);

                if (response.ok && data.success) {
                    notyf.success('✅ Solicitud enviada exitosamente');
                    setTimeout(() => {
                        window.location.href = '/dashboard/empresa';
                    }, 2000);
                } else {
                    // Mostrar errores de validación
                    if (data.errors) {
                        Object.values(data.errors).forEach(error => {
                            notyf.error(Array.isArray(error) ? error[0] : error);
                        });
                    } else {
                        // Mostrar mensaje de error o el error técnico
                        const errorMsg = data.message || data.error || 'Error al enviar la solicitud';
                        notyf.error(errorMsg);
                        console.error('Error del servidor:', errorMsg);
                    }
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = 'Enviar Solicitud';
                }

            } catch (error) {
                console.error('Error completo:', error);
                notyf.error('Error al procesar la solicitud. Revisa la consola para más detalles.');
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Enviar Solicitud';
            }
        });

        // Inicializar
        document.addEventListener('DOMContentLoaded', () => {
            cargarPlanes();
        });
    </script>

</body>
</html>

