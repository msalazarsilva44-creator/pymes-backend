<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos de Pago - MERCAROF</title>
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
        .main-bg { background-color: #f8fafc; }
    </style>
</head>
<body class="main-bg">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <a href="/dashboard/empresa" class="text-xl font-bold text-mercarof-navy">MERCAROF</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-600 font-medium">Métodos de Pago</span>
                </div>
                <a href="/dashboard/empresa" class="text-gray-600 hover:text-mercarof-cyan transition-colors font-medium text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header de página -->
        <div class="gradient-bg rounded-2xl p-6 text-white mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                    <span class="text-3xl">💳</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Métodos de Pago</h1>
                    <p class="text-white/80">Configura cómo recibir pagos de tus clientes</p>
                </div>
            </div>
        </div>

        <!-- Métodos de Pago -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- PayPal -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-gray-100 metodo-pago-card" data-tipo="paypal">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
                            <span class="text-3xl">💳</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">PayPal</h3>
                            <p class="text-sm text-gray-500">Recibe pagos con tarjeta</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer metodo-toggle" data-tipo="paypal">
                        <div class="w-14 h-7 bg-gray-200 peer-focus:ring-4 peer-focus:ring-mercarof-cyan/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-mercarof-cyan"></div>
                    </label>
                </div>
                <div class="metodo-fields hidden space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email de PayPal</label>
                        <input type="email" id="paypal_email" placeholder="tu-email@paypal.com" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                </div>
            </div>

            <!-- Binance -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-gray-100 metodo-pago-card" data-tipo="binance">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-yellow-50 rounded-xl flex items-center justify-center">
                            <span class="text-3xl">🪙</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Binance (USDT)</h3>
                            <p class="text-sm text-gray-500">Criptomonedas</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer metodo-toggle" data-tipo="binance">
                        <div class="w-14 h-7 bg-gray-200 peer-focus:ring-4 peer-focus:ring-mercarof-cyan/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-mercarof-cyan"></div>
                    </label>
                </div>
                <div class="metodo-fields hidden space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email de Binance</label>
                        <input type="email" id="binance_email" placeholder="tu-email@binance.com" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">O ID de Binance (USDT)</label>
                        <input type="text" id="binance_id" placeholder="ID de Binance Pay" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                </div>
            </div>

            <!-- Transferencia Bancaria -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-gray-100 metodo-pago-card" data-tipo="transferencia">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center">
                            <span class="text-3xl">🏦</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Transferencia Bancaria</h3>
                            <p class="text-sm text-gray-500">Depósito directo</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer metodo-toggle" data-tipo="transferencia">
                        <div class="w-14 h-7 bg-gray-200 peer-focus:ring-4 peer-focus:ring-mercarof-cyan/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-mercarof-cyan"></div>
                    </label>
                </div>
                <div class="metodo-fields hidden space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banco</label>
                            <input type="text" id="banco_nombre" placeholder="Nombre del Banco" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Cuenta</label>
                            <select id="banco_tipo_cuenta" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                                <option value="">Seleccionar</option>
                                <option value="corriente">Corriente</option>
                                <option value="ahorro">Ahorro</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Número de Cuenta</label>
                        <input type="text" id="banco_cuenta" placeholder="0000-0000-0000-0000" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Titular</label>
                        <input type="text" id="banco_titular" placeholder="Nombre completo" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cédula del Titular</label>
                        <input type="text" id="banco_cedula" placeholder="V-12345678" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                </div>
            </div>

            <!-- Pago Móvil -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border-2 border-gray-100 metodo-pago-card" data-tipo="pago_movil">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center">
                            <span class="text-3xl">📱</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Pago Móvil</h3>
                            <p class="text-sm text-gray-500">Transferencia instantánea</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer metodo-toggle" data-tipo="pago_movil">
                        <div class="w-14 h-7 bg-gray-200 peer-focus:ring-4 peer-focus:ring-mercarof-cyan/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-mercarof-cyan"></div>
                    </label>
                </div>
                <div class="metodo-fields hidden space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Código del Banco</label>
                        <input type="text" id="pago_movil_banco" placeholder="0102, 0134, 0175..." 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cédula</label>
                        <input type="text" id="pago_movil_cedula" placeholder="V-12345678" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                        <input type="text" id="pago_movil_telefono" placeholder="0412-1234567" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-mercarof-cyan focus:border-transparent transition-all">
                    </div>
                </div>
            </div>

        </div>

        <!-- Botón Guardar -->
        <div class="mt-8 flex justify-end">
            <button onclick="guardarMetodosPago()" id="btn-guardar" class="gradient-bg text-white font-bold py-4 px-10 rounded-xl hover:shadow-lg transition-all flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Guardar Cambios
            </button>
        </div>

    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let authToken = null;

        window.addEventListener('DOMContentLoaded', async () => {
            authToken = localStorage.getItem('auth_token');
            const userRole = localStorage.getItem('user_role');

            if (!authToken || userRole !== 'empresa') {
                window.location.href = '/login';
                return;
            }

            // Configurar toggles
            document.querySelectorAll('.metodo-toggle').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const card = this.closest('.metodo-pago-card');
                    const fields = card.querySelector('.metodo-fields');
                    if (this.checked) {
                        fields.classList.remove('hidden');
                        card.classList.remove('border-gray-100');
                        card.classList.add('border-mercarof-cyan');
                    } else {
                        fields.classList.add('hidden');
                        card.classList.add('border-gray-100');
                        card.classList.remove('border-mercarof-cyan');
                    }
                });
            });

            // Cargar métodos existentes
            await cargarMetodosPago();
        });

        async function cargarMetodosPago() {
            try {
                const response = await fetch(`${API_URL}/empresa/metodos-pago`, {
                    headers: {
                        'Authorization': `Bearer ${authToken}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success && result.data) {
                    Object.keys(result.data).forEach(tipo => {
                        const metodo = result.data[tipo];
                        if (metodo && metodo.activo) {
                            const toggle = document.querySelector(`.metodo-toggle[data-tipo="${tipo}"]`);
                            if (toggle) {
                                toggle.checked = true;
                                toggle.dispatchEvent(new Event('change'));
                                
                                switch(tipo) {
                                    case 'paypal':
                                        document.getElementById('paypal_email').value = metodo.paypal_email || '';
                                        break;
                                    case 'binance':
                                        document.getElementById('binance_email').value = metodo.binance_email || '';
                                        document.getElementById('binance_id').value = metodo.binance_id || '';
                                        break;
                                    case 'transferencia':
                                        document.getElementById('banco_nombre').value = metodo.banco_nombre || '';
                                        document.getElementById('banco_cuenta').value = metodo.banco_cuenta || '';
                                        document.getElementById('banco_titular').value = metodo.banco_titular || '';
                                        document.getElementById('banco_cedula').value = metodo.banco_cedula || '';
                                        document.getElementById('banco_tipo_cuenta').value = metodo.banco_tipo_cuenta || '';
                                        break;
                                    case 'pago_movil':
                                        document.getElementById('pago_movil_banco').value = metodo.pago_movil_banco || '';
                                        document.getElementById('pago_movil_cedula').value = metodo.pago_movil_cedula || '';
                                        document.getElementById('pago_movil_telefono').value = metodo.pago_movil_telefono || '';
                                        break;
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function guardarMetodosPago() {
            const btn = document.getElementById('btn-guardar');
            btn.disabled = true;
            btn.innerHTML = '<div class="animate-spin w-5 h-5 border-2 border-white border-t-transparent rounded-full"></div> Guardando...';

            const toggles = document.querySelectorAll('.metodo-toggle:checked');
            let guardados = 0;

            for (const toggle of toggles) {
                const tipo = toggle.dataset.tipo;
                let data = { tipo, activo: true };

                switch(tipo) {
                    case 'paypal':
                        data.paypal_email = document.getElementById('paypal_email').value;
                        break;
                    case 'binance':
                        data.binance_email = document.getElementById('binance_email').value;
                        data.binance_id = document.getElementById('binance_id').value;
                        break;
                    case 'transferencia':
                        data.banco_nombre = document.getElementById('banco_nombre').value;
                        data.banco_cuenta = document.getElementById('banco_cuenta').value;
                        data.banco_titular = document.getElementById('banco_titular').value;
                        data.banco_cedula = document.getElementById('banco_cedula').value;
                        data.banco_tipo_cuenta = document.getElementById('banco_tipo_cuenta').value;
                        break;
                    case 'pago_movil':
                        data.pago_movil_banco = document.getElementById('pago_movil_banco').value;
                        data.pago_movil_cedula = document.getElementById('pago_movil_cedula').value;
                        data.pago_movil_telefono = document.getElementById('pago_movil_telefono').value;
                        break;
                }

                try {
                    const response = await fetch(`${API_URL}/empresa/metodos-pago`, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${authToken}`,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    if ((await response.json()).success) guardados++;
                } catch (error) {}
            }

            // Desactivar métodos desmarcados
            const tiposTodos = ['paypal', 'binance', 'transferencia', 'pago_movil'];
            const tiposActivos = Array.from(toggles).map(t => t.dataset.tipo);
            
            for (const tipo of tiposTodos.filter(t => !tiposActivos.includes(t))) {
                try {
                    await fetch(`${API_URL}/empresa/metodos-pago/${tipo}`, {
                        method: 'DELETE',
                        headers: { 'Authorization': `Bearer ${authToken}` }
                    });
                } catch (error) {}
            }

            btn.disabled = false;
            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Guardar Cambios';
            
            alert('✅ Métodos de pago guardados exitosamente');
        }
    </script>

</body>
</html>
