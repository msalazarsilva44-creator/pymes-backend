<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title">Empresa - MERCAROF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="/mercarof-colors.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --mercarof-navy: #003B5C;
            --mercarof-navy-dark: #002942;
            --mercarof-navy-light: #004D73;
            --mercarof-cyan: #00A3E0;
            --mercarof-cyan-dark: #0082B8;
            --mercarof-cyan-light: #33B8E8;
        }
        
        * {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--mercarof-navy) 0%, var(--mercarof-cyan) 100%);
        }
        
        .gradient-bg-hero {
            background: linear-gradient(135deg, var(--mercarof-navy) 0%, var(--mercarof-navy-light) 50%, var(--mercarof-cyan) 100%);
        }
        
        .text-gradient-brand {
            background: linear-gradient(135deg, var(--mercarof-navy) 0%, var(--mercarof-cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .gallery-img {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .gallery-img:hover {
            transform: scale(1.05);
        }
        .main-bg {
            background-color: #f8fafc;
        }
        
        .btn-primary-brand {
            background-color: var(--mercarof-navy);
            transition: all 0.2s ease;
        }
        .btn-primary-brand:hover {
            background-color: var(--mercarof-navy-light);
            box-shadow: 0 4px 12px rgba(0, 59, 92, 0.25);
        }
        
        .btn-secondary-brand {
            background-color: var(--mercarof-cyan);
            transition: all 0.2s ease;
        }
        .btn-secondary-brand:hover {
            background-color: var(--mercarof-cyan-dark);
            box-shadow: 0 4px 12px rgba(0, 163, 224, 0.3);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Header mejorado */
        .header-shadow {
            box-shadow: 0 2px 8px rgba(0, 59, 92, 0.08);
        }
    </style>
</head>
<body class="main-bg">

    <!-- Header Mejorado -->
    <header class="bg-white header-shadow sticky top-0 z-40 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/dashboard/cliente" class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold tracking-tight text-gradient-brand">MERCAROF</span>
                </a>
                
                <!-- Navegación -->
                <div class="flex items-center gap-6">
                    <a id="btn-explorar-servicios" href="/dashboard/cliente" class="text-gray-600 hover:text-[#003B5C] transition-colors font-semibold text-sm tracking-wide">
                        Explorar Servicios
                    </a>
                    
                    <!-- Carrito de compras (solo para clientes) -->
                    <a href="/mis-compras" id="cart-link" class="hidden relative p-2 text-gray-600 hover:text-[#00A3E0] transition-colors" title="Mi Carrito">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="cart-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                    
                    <!-- Usuario Autenticado (Dinámico con JavaScript) -->
                    <div id="user-menu-container" class="hidden">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2.5 text-gray-700 hover:text-[#003B5C] font-medium transition-colors py-2 px-3 rounded-lg hover:bg-gray-50">
                                <div id="user-avatar" class="w-9 h-9 rounded-full bg-gradient-to-br from-[#003B5C] to-[#00A3E0] flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                    U
                                </div>
                                <span id="user-name-display" class="font-semibold text-sm hidden sm:block">Usuario</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Menú Desplegable -->
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100">
                                <div id="menu-empresa-links" class="hidden">
                                    <a href="/dashboard/empresa" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-[#003B5C]/5 hover:text-[#003B5C] transition-colors text-sm font-medium">
                                        <span class="text-base">📊</span> Mi Dashboard
                                    </a>
                                    <a href="/empresa/perfil" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-[#003B5C]/5 hover:text-[#003B5C] transition-colors text-sm font-medium">
                                        <span class="text-base">🏢</span> Mi Empresa
                                    </a>
                                </div>
                                <div id="menu-cliente-links" class="hidden">
                                    <a href="/dashboard/cliente" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-[#003B5C]/5 hover:text-[#003B5C] transition-colors text-sm font-medium">
                                        <span class="text-base">🏠</span> Inicio
                                    </a>
                                    <a href="/perfil/cliente" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-[#003B5C]/5 hover:text-[#003B5C] transition-colors text-sm font-medium">
                                        <span class="text-base">👤</span> Mi Perfil
                                    </a>
                                    <a href="/favoritos" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-[#003B5C]/5 hover:text-[#003B5C] transition-colors text-sm font-medium">
                                        <span class="text-base">❤️</span> Favoritos
                                    </a>
                                </div>
                                <div id="menu-admin-links" class="hidden">
                                    <a href="/dashboard/admin" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-[#003B5C]/5 hover:text-[#003B5C] transition-colors text-sm font-medium">
                                        <span class="text-base">⚙️</span> Panel Admin
                                    </a>
                                </div>
                                <hr class="my-2 border-gray-100">
                                <button onclick="logout()" class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors text-sm font-medium">
                                    <span class="text-base">🚪</span> Cerrar Sesión
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Usuario No Autenticado -->
                    <a id="login-button" href="/login" class="hidden btn-primary-brand text-white font-semibold py-2.5 px-5 rounded-lg text-sm tracking-wide">
                        Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Hero Section con info sobre el banner -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-8 border border-gray-100/80">
            <!-- Banner con contenido superpuesto -->
            <div id="empresa-banner-container" class="relative">
                <!-- Banner personalizado (si existe) -->
                <img id="empresa-banner" src="" alt="Banner" class="hidden w-full h-full object-cover absolute inset-0">
                <!-- Degradado por defecto con colores MERCAROF -->
                <div id="empresa-banner-gradient" class="gradient-bg-hero absolute inset-0"></div>
                <!-- Overlay para legibilidad -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
                
                <!-- Contenido sobre el banner -->
                <div class="relative z-10 px-6 sm:px-8 py-8 sm:py-10">
                    <div class="flex items-center gap-5">
                        <!-- Logo/Icono -->
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-white rounded-xl shadow-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img id="empresa-logo" src="" alt="Logo" class="w-full h-full object-cover hidden">
                            <span id="empresa-icono" class="text-3xl sm:text-4xl">🏢</span>
                        </div>
                        
                        <!-- Info Principal sobre banner - texto blanco -->
                        <div class="flex-1">
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight drop-shadow-sm" id="empresa-nombre">Cargando...</h1>
                            <p class="text-white/80 font-medium text-sm mt-1" id="empresa-categoria">Categoría</p>
                            
                            <!-- Badges -->
                            <div class="flex items-center gap-2 flex-wrap mt-3">
                                <div class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm px-2.5 py-1 rounded-lg">
                                    <span class="text-amber-400">⭐</span>
                                    <span class="font-bold text-white text-sm" id="empresa-rating">0.0</span>
                                    <span class="text-white/70 text-xs">(<span id="empresa-resenas">0</span>)</span>
                                </div>
                                <span id="empresa-verificado" class="hidden bg-white/20 backdrop-blur-sm text-white px-2.5 py-1 rounded-lg text-xs font-semibold">
                                    ✓ Verificado
                                </span>
                                <span id="empresa-plan" class="hidden px-2.5 py-1 rounded-lg text-xs font-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones y descripción (fuera del banner) -->
            <div class="px-6 sm:px-8 py-5">
                <!-- Botones de Acción -->
                <div class="flex flex-wrap items-center gap-2.5 mb-5">
                    <button onclick="contactarWhatsApp()" id="btn-whatsapp" class="bg-[#25D366] hover:bg-[#20BD5A] text-white font-semibold py-2.5 px-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <span class="text-sm">WhatsApp</span>
                    </button>
                    <button onclick="contactarTelefono()" class="bg-[#00A3E0] hover:bg-[#0082B8] text-white font-semibold py-2.5 px-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm">Llamar</span>
                    </button>
                    <button onclick="toggleFavorito()" class="bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-[#003B5C] font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-sm">Guardar</span>
                    </button>
                </div>
                
                <!-- Descripción -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-gray-500 leading-relaxed text-sm" id="empresa-descripcion">Descripción de la empresa...</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Columna Principal -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Galería de Fotos -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100/80">
                    <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-[#00A3E0]/10 flex items-center justify-center text-lg">📸</span>
                        <span>Galería</span>
                    </h2>
                    <div id="galeria" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="col-span-full text-center py-10 text-gray-400">
                            No hay fotos disponibles
                        </div>
                    </div>
                </div>

                <!-- Servicios -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100/80">
                    <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-[#003B5C]/10 flex items-center justify-center text-lg">💼</span>
                        <span>Servicios</span>
                    </h2>
                    <div id="servicios" class="space-y-3">
                        <div class="text-center py-10 text-gray-400">
                            No hay servicios registrados
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100/80">
                    <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-lg">📦</span>
                        <span>Productos</span>
                    </h2>
                    <div id="productos" class="space-y-3">
                        <div class="text-center py-10 text-gray-400">
                            No hay productos registrados
                        </div>
                    </div>
                </div>

                <!-- Reseñas -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100/80">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-lg">⭐</span>
                            <span>Reseñas</span>
                        </h2>
                        <button id="btn-escribir-resena" onclick="toggleFormularioResena()" class="hidden btn-primary-brand text-white font-bold px-5 py-2.5 rounded-xl transition-all duration-200 hover:scale-[1.02] shadow-md text-sm">
                            ✍️ Escribir reseña
                        </button>
                    </div>

                    <!-- Formulario para escribir reseña -->
                    <div id="formulario-resena" class="hidden mb-6 p-6 bg-gradient-to-br from-[#003B5C]/5 to-[#00A3E0]/5 rounded-xl border border-[#00A3E0]/20">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Escribe tu reseña</h3>
                        
                        <!-- Calificación con estrellas -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Calificación *</label>
                            <div class="flex gap-2" id="rating-stars">
                                <button type="button" onclick="setRating(1)" class="text-3xl text-gray-300 hover:text-amber-500 transition-colors">★</button>
                                <button type="button" onclick="setRating(2)" class="text-3xl text-gray-300 hover:text-amber-500 transition-colors">★</button>
                                <button type="button" onclick="setRating(3)" class="text-3xl text-gray-300 hover:text-amber-500 transition-colors">★</button>
                                <button type="button" onclick="setRating(4)" class="text-3xl text-gray-300 hover:text-amber-500 transition-colors">★</button>
                                <button type="button" onclick="setRating(5)" class="text-3xl text-gray-300 hover:text-amber-500 transition-colors">★</button>
                            </div>
                            <input type="hidden" id="rating-value" value="0">
                            <p id="error-rating" class="text-xs text-red-600 mt-1 hidden">Debes seleccionar una calificación</p>
                        </div>

                        <!-- Campo de texto -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tu reseña * <span class="text-xs text-gray-400 font-normal">(máximo 100 caracteres)</span>
                            </label>
                            <textarea 
                                id="comentario-resena" 
                                rows="3" 
                                maxlength="100"
                                placeholder="Comparte tu experiencia con esta empresa..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#00A3E0] focus:border-transparent resize-none transition-all"
                            ></textarea>
                            <div class="flex justify-between mt-1">
                                <p id="error-comentario" class="text-xs text-red-600 hidden">Debes escribir algo en tu reseña</p>
                                <p class="text-xs text-gray-400"><span id="char-count">0</span>/100 caracteres</p>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-3">
                            <button onclick="cancelarResena()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-4 rounded-xl transition-all">
                                Cancelar
                            </button>
                            <button onclick="enviarResena()" id="btn-enviar-resena" class="flex-1 btn-primary-brand text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-md">
                                Publicar reseña
                            </button>
                        </div>
                    </div>

                    <div id="resenas" class="space-y-4">
                        <div class="text-center py-8 text-gray-500">
                            No hay reseñas todavía
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Información de Contacto -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100/80">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-[#00A3E0]/10 flex items-center justify-center text-base">📞</span>
                        <span>Contacto</span>
                    </h3>
                    <div class="space-y-4">
                        <div class="group">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Teléfono</p>
                            <p class="font-semibold text-gray-900" id="contacto-telefono">-</p>
                        </div>
                        <div class="group">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Email</p>
                            <p class="font-semibold text-sm text-gray-900 break-words" id="contacto-email">-</p>
                        </div>
                        <div class="group">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Dirección</p>
                            <p class="font-semibold text-sm text-gray-900" id="contacto-direccion">-</p>
                        </div>
                        <div class="group">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Ciudad</p>
                            <p class="font-semibold text-gray-900" id="contacto-ciudad">-</p>
                        </div>
                    </div>
                </div>

                <!-- Horarios -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100/80">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-[#003B5C]/10 flex items-center justify-center text-base">🕐</span>
                        <span>Horarios</span>
                    </h3>
                    <div id="horarios" class="space-y-2.5">
                        <div class="text-sm text-gray-400">
                            No hay horarios configurados
                        </div>
                    </div>
                </div>

                <!-- Redes Sociales -->
                <div id="redes-sociales" class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100/80 hidden">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-base">🌐</span>
                        <span>Redes Sociales</span>
                    </h3>
                    <div class="flex flex-col gap-2.5" id="redes-links">
                        <!-- Se llenarán dinámicamente -->
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Modal para ver foto completa -->
    <div id="modal-foto" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="cerrarModalFoto()">
        <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
            <button onclick="cerrarModalFoto()" class="absolute -top-10 right-0 text-white text-3xl hover:text-gray-300">×</button>
            <img id="modal-imagen" src="" alt="" class="w-full rounded-lg">
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:8000/api';
        let empresaId = null;
        let empresaData = null;

        // Función para cerrar sesión
        function logout() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            localStorage.removeItem('user_role');
            localStorage.removeItem('empresa_data');
            window.location.href = '/login';
        }

        // Inicializar menú de usuario
        function initUserMenu() {
            const userData = localStorage.getItem('user_data');
            const userRole = localStorage.getItem('user_role');
            const token = localStorage.getItem('auth_token');

            const userMenuContainer = document.getElementById('user-menu-container');
            const loginButton = document.getElementById('login-button');

            if (token && userData) {
                // Usuario autenticado
                try {
                    const user = JSON.parse(userData);
                    
                    // Mostrar menú de usuario
                    userMenuContainer.classList.remove('hidden');
                    loginButton.classList.add('hidden');
                    
                    // Actualizar nombre y avatar
                    document.getElementById('user-name-display').textContent = user.name || 'Usuario';
                    document.getElementById('user-avatar').textContent = (user.name || 'U').charAt(0).toUpperCase();
                    
                    // Mostrar menú según rol
                    if (userRole === 'empresa') {
                        document.getElementById('menu-empresa-links').classList.remove('hidden');
                    } else if (userRole === 'cliente') {
                        document.getElementById('menu-cliente-links').classList.remove('hidden');
                        // Mostrar carrito para clientes
                        document.getElementById('cart-link').classList.remove('hidden');
                        cargarContadorCarrito();
                    } else if (userRole === 'admin') {
                        document.getElementById('menu-admin-links').classList.remove('hidden');
                    }
                } catch (e) {
                    console.error('Error al parsear user_data:', e);
                    loginButton.classList.remove('hidden');
                }
            } else {
                // Usuario no autenticado
                loginButton.classList.remove('hidden');
            }
        }

        // Llamar inmediatamente
        initUserMenu();

        window.addEventListener('DOMContentLoaded', async () => {
            // Obtener ID de la URL
            const pathParts = window.location.pathname.split('/');
            empresaId = pathParts[pathParts.length - 1];

            if (!empresaId || isNaN(empresaId)) {
                alert('Empresa no encontrada');
                window.location.href = '/';
                return;
            }

            await cargarEmpresa();
        });

        // Cargar empresa
        async function cargarEmpresa() {
            try {
                // Incluir token si el usuario está autenticado
                const token = localStorage.getItem('auth_token');
                const headers = {};
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }
                
                const response = await fetch(`${API_URL}/empresas/${empresaId}`, {
                    headers: headers
                });
                const result = await response.json();

                if (result.success) {
                    empresaData = result.data;
                    renderizarEmpresa(empresaData);
                } else {
                    alert('No se pudo cargar la empresa');
                    window.location.href = '/';
                }
            } catch (error) {
                console.error('Error cargando empresa:', error);
                alert('Error de conexión');
            }
        }

        // Renderizar empresa
        function renderizarEmpresa(empresa) {
            // Verificar si el usuario autenticado es el dueño de la empresa
            const btnExplorar = document.getElementById('btn-explorar-servicios');
            
            // Verificar desde localStorage (API token)
            const userData = localStorage.getItem('user_data');
            let esPropietario = false;
            
            if (userData && empresa.user_id) {
                try {
                    const user = JSON.parse(userData);
                    // Si el usuario es empresa y su ID coincide con el user_id de la empresa
                    if (user.role && user.role.name === 'empresa' && user.id && parseInt(user.id) === parseInt(empresa.user_id)) {
                        esPropietario = true;
                    }
                } catch (e) {
                    console.error('Error verificando usuario desde localStorage:', e);
                }
            }
            
            // También verificar desde la sesión web si el usuario está autenticado
            @auth
                @if(auth()->user()->isEmpresa() && auth()->user()->empresa)
                    // Comparar el ID de la empresa actual con la empresa del usuario
                    if (parseInt(empresa.id) === parseInt({{ auth()->user()->empresa->id ?? 'null' }})) {
                        esPropietario = true;
                    }
                @endif
            @endauth
            
            // Nota: Botón "Explorar servicios" ahora se muestra siempre, incluso para propietarios
            // if (esPropietario && btnExplorar) {
            //     btnExplorar.style.display = 'none';
            // }
            
            // Título de la página
            document.getElementById('page-title').textContent = `${empresa.nombre_comercial} - MERCAROF`;
            
            // Banner personalizado
            if (empresa.banner) {
                const bannerImg = document.getElementById('empresa-banner');
                const bannerGradient = document.getElementById('empresa-banner-gradient');
                bannerImg.src = empresa.banner;
                bannerImg.classList.remove('hidden');
                bannerGradient.classList.add('hidden');
            } else {
                // Mostrar degradado por defecto
                document.getElementById('empresa-banner').classList.add('hidden');
                document.getElementById('empresa-banner-gradient').classList.remove('hidden');
            }
            
            // Logo o ícono
            if (empresa.logo) {
                document.getElementById('empresa-logo').src = empresa.logo;
                document.getElementById('empresa-logo').classList.remove('hidden');
                document.getElementById('empresa-icono').classList.add('hidden');
            } else {
                document.getElementById('empresa-icono').textContent = empresa.categoria?.icono || '🏢';
            }
            
            // Información básica
            document.getElementById('empresa-nombre').textContent = empresa.nombre_comercial;
            document.getElementById('empresa-categoria').textContent = empresa.categoria?.nombre || 'Servicio';
            document.getElementById('empresa-descripcion').textContent = empresa.descripcion || 'Sin descripción disponible';
            
            // Rating
            document.getElementById('empresa-rating').textContent = empresa.calificacion_promedio || '0.0';
            document.getElementById('empresa-resenas').textContent = empresa.total_resenas || '0';
            
            // Verificado
            if (empresa.verificado) {
                document.getElementById('empresa-verificado').classList.remove('hidden');
            }
            
            // Plan
            if (empresa.plan?.slug === 'premium') {
                const planSpan = document.getElementById('empresa-plan');
                planSpan.classList.remove('hidden');
                planSpan.classList.add('bg-gradient-to-r', 'from-yellow-400', 'to-yellow-600', 'text-white');
                planSpan.textContent = '👑 Premium';
            } else if (empresa.plan?.slug === 'basico') {
                const planSpan = document.getElementById('empresa-plan');
                planSpan.classList.remove('hidden');
                planSpan.classList.add('bg-gray-300', 'text-gray-800');
                planSpan.textContent = '⭐ Básico';
            }
            
            // Contacto
            document.getElementById('contacto-telefono').textContent = empresa.telefono || 'No disponible';
            document.getElementById('contacto-email').textContent = empresa.email_contacto || 'No disponible';
            document.getElementById('contacto-direccion').textContent = empresa.direccion || 'No disponible';
            document.getElementById('contacto-ciudad').textContent = empresa.ciudad ? `${empresa.ciudad.nombre}, ${empresa.ciudad.estado}` : 'No disponible';
            
            // Galería
            if (empresa.fotos && empresa.fotos.length > 0) {
                const galeriaDiv = document.getElementById('galeria');
                galeriaDiv.innerHTML = empresa.fotos.map(foto => `
                    <img src="${foto.url}" alt="${foto.descripcion || 'Foto de la empresa'}" 
                         class="w-full h-48 object-cover rounded-lg gallery-img"
                         onclick="abrirModalFoto('${foto.url}')">
                `).join('');
            }
            
            // Servicios
            const userRole = localStorage.getItem('user_role');
            const isCliente = userRole === 'cliente';
            
            if (empresa.servicios && empresa.servicios.length > 0) {
                const serviciosDiv = document.getElementById('servicios');
                serviciosDiv.innerHTML = empresa.servicios.map(servicio => `
                    <div class="border border-gray-100 rounded-xl p-4 hover:border-[#00A3E0]/30 hover:shadow-md transition-all duration-200 bg-gray-50/50 group">
                        <div class="flex justify-between items-center gap-4">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 group-hover:text-[#003B5C] transition-colors">${servicio.nombre}</h4>
                                ${servicio.descripcion ? `<p class="text-sm text-gray-500 mt-1">${servicio.descripcion}</p>` : ''}
                            </div>
                            <div class="flex items-center gap-3 flex-shrink-0">
                                ${servicio.precio ? `<span class="text-[#00A3E0] font-bold text-lg whitespace-nowrap">${servicio.precio}</span>` : ''}
                                ${isCliente ? `
                                    <button onclick="addToCart(${servicio.id})" class="p-2 bg-[#003B5C] hover:bg-[#004D73] text-white rounded-lg transition-all duration-200 hover:scale-105" title="Agregar al carrito">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Productos
            if (empresa.productos && empresa.productos.length > 0) {
                const productosDiv = document.getElementById('productos');
                productosDiv.innerHTML = empresa.productos.map(p => {
                    const imgs = p.imagenes && p.imagenes.length ? p.imagenes : [];
                    const mainUrl = imgs.length ? imgs[0].url : '';
                    const galeriaHtml = imgs.length ? `
                        <div class="mt-3 space-y-2">
                            <div class="rounded-xl overflow-hidden bg-gray-100 max-h-56 aspect-video">
                                <img id="prod-main-${p.id}" src="${mainUrl}" alt="${p.nombre}"
                                    class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity"
                                    onclick="abrirModalFoto(document.getElementById('prod-main-${p.id}').src)">
                            </div>
                            ${imgs.length > 1 ? `
                            <div class="flex gap-2 overflow-x-auto pb-1 snap-x snap-mandatory scrollbar-thin">
                                ${imgs.map(im => `
                                    <button type="button" onclick="setProdMainImg(${p.id}, this.getAttribute('data-u'))" data-u="${im.url.replace(/"/g, '&quot;')}"
                                        class="flex-shrink-0 w-16 h-16 rounded-lg border-2 border-transparent hover:border-[#00A3E0] overflow-hidden snap-start shadow-sm">
                                        <img src="${im.url}" alt="" class="w-full h-full object-cover">
                                    </button>
                                `).join('')}
                            </div>` : ''}
                        </div>
                    ` : '';
                    return `
                    <div class="border border-gray-100 rounded-xl p-4 hover:border-emerald-200 hover:shadow-md transition-all duration-200 bg-gray-50/50 group">
                        ${galeriaHtml}
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 ${imgs.length ? 'mt-3' : ''}">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h4 class="font-bold text-gray-900 group-hover:text-[#003B5C] transition-colors">${p.nombre}</h4>
                                    ${p.es_basico ? '<span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full font-semibold">Básico</span>' : ''}
                                </div>
                                ${p.descripcion ? `<p class="text-sm text-gray-500 mt-1">${p.descripcion}</p>` : ''}
                                <p class="text-xs text-gray-400 mt-1">Stock: ${p.cantidad}</p>
                            </div>
                            <div class="flex items-center gap-3 flex-shrink-0">
                                <span class="text-[#00A3E0] font-bold text-lg whitespace-nowrap">$${parseFloat(p.precio).toFixed(2)}</span>
                                ${isCliente && p.cantidad > 0 ? `
                                    <div class="flex items-center gap-2">
                                        <label class="text-xs text-gray-500 sr-only">Cantidad</label>
                                        <input type="number" min="1" max="${p.cantidad}" value="1" id="qty-prod-${p.id}"
                                            class="w-16 px-2 py-1.5 border border-gray-200 rounded-lg text-sm text-center font-semibold">
                                        <button onclick="addToCartProducto(${p.id})" class="p-2 bg-[#003B5C] hover:bg-[#004D73] text-white rounded-lg transition-all duration-200 hover:scale-105" title="Agregar al carrito">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                ` : ''}
                                ${isCliente && p.cantidad <= 0 ? '<span class="text-xs text-red-500 font-semibold">Agotado</span>' : ''}
                            </div>
                        </div>
                    </div>
                `;
                }).join('');
            } else {
                document.getElementById('productos').innerHTML = `
                    <div class="text-center py-10 text-gray-400">No hay productos registrados</div>`;
            }
            
            // Horarios
            if (empresa.horarios && empresa.horarios.length > 0) {
                const horariosDiv = document.getElementById('horarios');
                horariosDiv.innerHTML = empresa.horarios.map(h => `
                    <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                        <span class="font-semibold text-gray-900 text-sm">${h.dia_semana}</span>
                        <span class="text-[#00A3E0] font-medium text-sm">${h.hora_apertura} - ${h.hora_cierre}</span>
                    </div>
                `).join('');
            }
            
            // Redes Sociales
            const redesSociales = [];
            if (empresa.facebook) redesSociales.push({ 
                nombre: 'Facebook', 
                url: empresa.facebook, 
                icono: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>', 
                color: 'bg-blue-600' 
            });
            if (empresa.instagram) redesSociales.push({ 
                nombre: 'Instagram', 
                url: empresa.instagram, 
                icono: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>', 
                color: 'bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500' 
            });
            if (empresa.twitter) redesSociales.push({ 
                nombre: 'Twitter', 
                url: empresa.twitter, 
                icono: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>', 
                color: 'bg-sky-500' 
            });
            if (empresa.linkedin) redesSociales.push({ 
                nombre: 'LinkedIn', 
                url: empresa.linkedin, 
                icono: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>', 
                color: 'bg-blue-700' 
            });
            if (empresa.youtube) redesSociales.push({ 
                nombre: 'YouTube', 
                url: empresa.youtube, 
                icono: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>', 
                color: 'bg-red-600' 
            });
            if (empresa.tiktok) redesSociales.push({ 
                nombre: 'TikTok', 
                url: empresa.tiktok, 
                icono: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>', 
                color: 'bg-black' 
            });
            
            if (redesSociales.length > 0) {
                document.getElementById('redes-sociales').classList.remove('hidden');
                const redesLinks = document.getElementById('redes-links');
                redesLinks.innerHTML = redesSociales.map(red => `
                    <a href="${red.url}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center gap-3 p-3 ${red.color} text-white rounded-lg hover:opacity-90 transition-opacity">
                        <span class="flex-shrink-0">${red.icono}</span>
                        <span class="font-medium">${red.nombre}</span>
                        <span class="ml-auto text-sm">→</span>
                    </a>
                `).join('');
            }

            // Cargar reseñas
            if (empresa.resenas && empresa.resenas.length > 0) {
                const resenasDiv = document.getElementById('resenas');
                resenasDiv.innerHTML = empresa.resenas.map(resena => `
                    <div class="bg-gray-50/70 rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[#003B5C] to-[#00A3E0] flex items-center justify-center text-white font-bold shadow-sm">
                                    ${(resena.user?.name || 'U').charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">${resena.user?.name || 'Usuario'}</p>
                                    <div class="flex items-center gap-0.5">
                                        ${Array.from({length: 5}, (_, i) => 
                                            `<span class="${i < resena.calificacion ? 'text-amber-500' : 'text-gray-300'} text-sm">★</span>`
                                        ).join('')}
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-400 font-medium">${new Date(resena.created_at).toLocaleDateString('es-ES')}</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed">${resena.comentario}</p>
                        ${resena.respuesta_empresa ? `
                            <div class="mt-4 ml-4 pl-4 border-l-2 border-[#00A3E0]/30 bg-[#00A3E0]/5 p-4 rounded-lg">
                                <p class="text-xs font-bold text-[#003B5C] mb-1.5">Respuesta de la empresa:</p>
                                <p class="text-sm text-gray-600">${resena.respuesta_empresa}</p>
                            </div>
                        ` : ''}
                    </div>
                `).join('');
            } else {
                const resenasDiv = document.getElementById('resenas');
                resenasDiv.innerHTML = '<div class="text-center py-10 text-gray-400">No hay reseñas todavía</div>';
            }
        }

        // Modal de foto
        function setProdMainImg(productoId, url) {
            const el = document.getElementById('prod-main-' + productoId);
            if (el && url) el.src = url;
        }

        function abrirModalFoto(url) {
            document.getElementById('modal-imagen').src = url;
            document.getElementById('modal-foto').classList.remove('hidden');
        }

        function cerrarModalFoto() {
            document.getElementById('modal-foto').classList.add('hidden');
        }

        // Contactar por WhatsApp
        function contactarWhatsApp() {
            if (empresaData?.telefono) {
                const numero = empresaData.telefono.replace(/\D/g, '');
                window.open(`https://wa.me/${numero}`, '_blank');
            } else {
                alert('WhatsApp no disponible');
            }
        }

        // Contactar por teléfono
        function contactarTelefono() {
            if (empresaData?.telefono) {
                window.location.href = `tel:${empresaData.telefono}`;
            } else {
                alert('Teléfono no disponible');
            }
        }

        // Toggle favorito
        function toggleFavorito() {
            alert('Funcionalidad de favoritos próximamente. Inicia sesión para guardar empresas.');
        }

        // ==================== FUNCIONES PARA RESEÑAS ====================
        
        let selectedRating = 0;

        // Mostrar/ocultar formulario de reseña
        function toggleFormularioResena() {
            const formulario = document.getElementById('formulario-resena');
            const btn = document.getElementById('btn-escribir-resena');
            
            if (formulario.classList.contains('hidden')) {
                formulario.classList.remove('hidden');
                formulario.classList.add('animate-fadeIn');
                btn.textContent = '❌ Cancelar';
            } else {
                formulario.classList.add('hidden');
                btn.textContent = '✍️ Escribir reseña';
            }
        }

        // Cancelar reseña
        function cancelarResena() {
            toggleFormularioResena();
            document.getElementById('comentario-resena').value = '';
            document.getElementById('char-count').textContent = '0';
            selectedRating = 0;
            updateStars();
        }

        // Establecer rating
        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating-value').value = rating;
            updateStars();
        }

        // Actualizar estrellas visuales
        function updateStars() {
            const stars = document.querySelectorAll('#rating-stars button');
            stars.forEach((star, index) => {
                if (index < selectedRating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-amber-500');
                } else {
                    star.classList.remove('text-amber-500');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Contador de caracteres
        document.addEventListener('DOMContentLoaded', () => {
            const textarea = document.getElementById('comentario-resena');
            if (textarea) {
                textarea.addEventListener('input', (e) => {
                    const count = e.target.value.length;
                    document.getElementById('char-count').textContent = count;
                    
                    // Ocultar error si ya escribió algo
                    if (count > 0) {
                        document.getElementById('error-comentario').classList.add('hidden');
                        textarea.classList.remove('border-red-500');
                    }
                });
            }
        });

        // Enviar reseña
        async function enviarResena() {
            const comentario = document.getElementById('comentario-resena').value.trim();
            const rating = selectedRating;
            const token = localStorage.getItem('auth_token');

            // Validaciones
            let hasError = false;

            // Validar rating
            if (rating === 0) {
                document.getElementById('error-rating').classList.remove('hidden');
                hasError = true;
            } else {
                document.getElementById('error-rating').classList.add('hidden');
            }

            // Validar comentario (debe tener al menos algo escrito)
            if (comentario.length === 0) {
                document.getElementById('error-comentario').classList.remove('hidden');
                document.getElementById('comentario-resena').classList.add('border-red-500');
                hasError = true;
            } else {
                document.getElementById('error-comentario').classList.add('hidden');
                document.getElementById('comentario-resena').classList.remove('border-red-500');
            }

            if (hasError) {
                return;
            }

            // Verificar autenticación
            if (!token) {
                alert('Debes iniciar sesión para escribir una reseña');
                window.location.href = '/login';
                return;
            }

            // Enviar reseña
            const btnEnviar = document.getElementById('btn-enviar-resena');
            btnEnviar.disabled = true;
            btnEnviar.textContent = 'Enviando...';

            try {
                const response = await fetch(`${API_URL}/empresas/${empresaId}/resenas`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        calificacion: rating,
                        comentario: comentario
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ ¡Reseña publicada exitosamente!');
                    cancelarResena();
                    await cargarEmpresa(); // Recargar empresa para actualizar reseñas
                } else {
                    alert('❌ Error: ' + (result.message || 'No se pudo publicar la reseña'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error al enviar la reseña');
            } finally {
                btnEnviar.disabled = false;
                btnEnviar.textContent = 'Publicar reseña';
            }
        }

        // Mostrar botón de escribir reseña solo para clientes autenticados
        function verificarPermisoResena() {
            const userRole = localStorage.getItem('user_role');
            const token = localStorage.getItem('auth_token');
            
            if (token && userRole === 'cliente') {
                document.getElementById('btn-escribir-resena').classList.remove('hidden');
            }
        }

        // Llamar al cargar la página
        verificarPermisoResena();

        // Asegurar que el botón de WhatsApp sea visible
        window.addEventListener('DOMContentLoaded', () => {
            const btnWhatsApp = document.getElementById('btn-whatsapp');
            if (btnWhatsApp) {
                btnWhatsApp.style.display = 'flex';
                btnWhatsApp.style.visibility = 'visible';
                btnWhatsApp.style.opacity = '1';
                btnWhatsApp.classList.remove('hidden');
            }
        });

        // ==================== CARRITO DE COMPRAS ====================

        // Cargar contador del carrito
        async function cargarContadorCarrito() {
            const token = localStorage.getItem('auth_token');
            if (!token) return;
            
            try {
                const response = await fetch(`${API_URL}/carrito/count`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();
                
                if (result.success) {
                    const badge = document.getElementById('cart-badge');
                    if (result.count > 0) {
                        badge.textContent = result.count > 99 ? '99+' : result.count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error cargando carrito:', error);
            }
        }

        // Añadir servicio al carrito
        async function addToCart(servicioId) {
            const token = localStorage.getItem('auth_token');
            const userRole = localStorage.getItem('user_role');
            
            if (!token) {
                alert('Debes iniciar sesión para agregar servicios al carrito');
                window.location.href = '/login';
                return;
            }
            
            if (userRole !== 'cliente') {
                alert('Solo los clientes pueden agregar servicios al carrito');
                return;
            }
            
            try {
                const response = await fetch(`${API_URL}/carrito`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ servicio_id: servicioId })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Actualizar contador
                    const badge = document.getElementById('cart-badge');
                    badge.textContent = result.cart_count > 99 ? '99+' : result.cart_count;
                    badge.classList.remove('hidden');
                    
                    // Mostrar notificación
                    showToast('✅ Servicio agregado al carrito', 'success');
                } else {
                    showToast(result.message || 'No se pudo agregar al carrito', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error al agregar al carrito', 'error');
            }
        }

        async function addToCartProducto(productoId) {
            const token = localStorage.getItem('auth_token');
            const userRole = localStorage.getItem('user_role');
            const qtyInput = document.getElementById('qty-prod-' + productoId);
            let cantidad = qtyInput ? parseInt(qtyInput.value, 10) : 1;
            if (!cantidad || cantidad < 1) cantidad = 1;

            if (!token) {
                alert('Debes iniciar sesión para comprar');
                window.location.href = '/login';
                return;
            }
            if (userRole !== 'cliente') {
                alert('Solo los clientes pueden agregar productos al carrito');
                return;
            }

            try {
                const response = await fetch(`${API_URL}/carrito`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ producto_id: productoId, cantidad: cantidad })
                });
                const result = await response.json();
                if (result.success) {
                    const badge = document.getElementById('cart-badge');
                    badge.textContent = result.cart_count > 99 ? '99+' : result.cart_count;
                    badge.classList.remove('hidden');
                    showToast('✅ Producto agregado al carrito', 'success');
                } else {
                    showToast(result.message || 'No se pudo agregar', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error al agregar al carrito', 'error');
            }
        }

        // Mostrar toast de notificación
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fadeIn`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>

</body>
</html>

