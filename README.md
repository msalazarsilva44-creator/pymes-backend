# 🏢 ServiLocal - Plataforma de Servicios Locales

> Conecta tu negocio con la visibilidad que necesita.

## 📋 Descripción

**ServiLocal** es una plataforma completa que conecta empresas locales de servicios con clientes potenciales. Sistema de monetización basado en planes de suscripción con posicionamiento premium.

---

## ✨ Características Principales

### 🎯 Para Empresas (Monetización)
- ✅ **3 Planes de Suscripción**: Gratis, Básico ($5/mes), Premium ($10/mes)
- ✅ **Múltiples Métodos de Pago**: Banco, Binance, PayPal, Zelle
- ✅ **Posicionamiento Inteligente**: Las empresas premium aparecen en Top 3
- ✅ **Panel de Métricas**: Vistas, clics, conversiones, ROI
- ✅ **Perfiles Completos**: Fotos, servicios, horarios, ubicación
- ✅ **Sistema de Reseñas**: Calificaciones y respuestas
- ✅ **Notificaciones en Tiempo Real**: Alertas de aprobación, vencimientos y más
- ✅ **Desktop App**: Notificaciones push en tiempo real (Próximamente)

### 👥 Para Clientes (Tráfico)
- ✅ **Búsqueda Avanzada**: Por categoría y ciudad
- ✅ **Perfiles Verificados**: Empresas con documentos validados
- ✅ **Opiniones Reales**: Sistema de reseñas transparente
- ✅ **Contacto Directo**: Teléfono, WhatsApp, sitio web

---

## 🏗️ Estructura del Proyecto

```
Sistema PYMES/
├── 🌐 Frontend
│   ├── index.html                    ← Landing Page
│   ├── resources/views/
│   │   └── landing.blade.php         ← Versión Blade
│   └── run.bat                       ← Servidor Frontend (Puerto 3004)
│
├── ⚙️ Backend (Laravel + MySQL)
│   ├── app/
│   │   ├── Models/                   ← 11 Modelos Eloquent
│   │   └── Http/Controllers/Api/     ← 6 Controladores REST
│   ├── database/
│   │   ├── migrations/               ← 14 Migraciones
│   │   └── seeders/                  ← 6 Seeders con datos de prueba
│   ├── routes/
│   │   └── api.php                   ← 25+ Endpoints API
│   └── config/
│       └── database.php              ← Configuración MySQL
│
└── 📄 Documentación
    ├── BACKEND_SETUP.md              ← Instalación del Backend
    ├── ENV_INSTRUCTIONS.txt          ← Configuración .env
    ├── start-backend.bat             ← Iniciar API (Puerto 8000)
    └── setup-db.bat                  ← Configurar Base de Datos
```

---

## 🚀 Inicio Rápido

### 1️⃣ **Ver la Landing Page**

```bash
# Ejecuta el servidor frontend
run.bat

# O manualmente
php -S localhost:3004 -t .
```

**Abre:** http://localhost:3004

---

### 2️⃣ **Configurar el Backend API**

#### a) Iniciar MySQL en XAMPP

Abre **XAMPP Control Panel** y arranca:
- ✅ Apache
- ✅ MySQL

#### b) Crear Base de Datos

Abre **phpMyAdmin**: http://localhost/phpmyadmin

Ejecuta:
```sql
CREATE DATABASE servilocal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### c) Crear archivo .env

Crea un archivo `.env` en la raíz con este contenido:

```env
APP_NAME=ServiLocal
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=servilocal
DB_USERNAME=root
DB_PASSWORD=

PLAN_FREE_PRICE=0
PLAN_BASIC_PRICE=5
PLAN_PREMIUM_PRICE=10
PLAN_ANNUAL_DISCOUNT=0.10
```

#### d) Configurar Base de Datos

```bash
# Opción 1: Usar el script automatizado
setup-db.bat

# Opción 2: Manualmente
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

#### e) Iniciar API

```bash
# Usar el script
start-backend.bat

# O manualmente
php artisan serve --port=8000
```

**API URL:** http://localhost:8000/api

---

## 🧪 Probar la API

### Test de Conexión

```bash
curl http://localhost:8000/api/ping
```

### Login (Obtener Token)

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@servilocal.com","password":"password"}'
```

### Buscar Empresas

```bash
# Todas
curl http://localhost:8000/api/empresas

# Por categoría
curl "http://localhost:8000/api/empresas?categoria_id=1"

# Por ciudad
curl "http://localhost:8000/api/empresas?ciudad_id=1"

# Buscar por nombre
curl "http://localhost:8000/api/empresas?search=plomeria"
```

---

## 👥 Usuarios de Prueba

| Rol | Email | Password | Descripción |
|-----|-------|----------|-------------|
| **Admin** | admin@servilocal.com | password | Administrador completo |
| **Cliente** | cliente@test.com | password | Cliente de prueba |
| **Empresa** | maria@plomeria.com | password | Plomería Rápida (Premium) |
| **Empresa** | carlos@electricidad.com | password | Electricidad (Básico) |
| **Empresa** | ana@carpinteria.com | password | Carpintería (Gratis) |

---

## 📡 Endpoints Principales

### Públicos
- `GET /api/empresas` - Buscar empresas
- `GET /api/categorias` - Listar categorías
- `GET /api/ciudades` - Listar ciudades
- `GET /api/planes` - Ver planes de suscripción
- `POST /api/auth/register/cliente` - Registrar cliente
- `POST /api/auth/register/empresa` - Registrar empresa
- `POST /api/auth/login` - Iniciar sesión

### Protegidos (requieren Bearer token)
- `GET /api/auth/me` - Perfil actual
- `PUT /api/empresas/{id}` - Actualizar empresa
- `GET /api/empresas/{id}/metricas` - Ver estadísticas
- `POST /api/empresas/{id}/resenas` - Crear reseña

**Documentación completa:** Ver `BACKEND_SETUP.md`

---

## 🛠️ Tecnologías Utilizadas

### Frontend
- HTML5 + Tailwind CSS (vía CDN)
- JavaScript Vanilla
- Blade Templates (Laravel)
- Diseño 100% Responsivo

### Backend
- PHP 8.2+
- Laravel 10
- MySQL 8.0
- Laravel Sanctum (API Authentication)
- Eloquent ORM

---

## 📊 Base de Datos

### Tablas Principales (14 total):
1. **roles** - 3 roles: Admin, Empresa, Cliente
2. **users** - Usuarios del sistema
3. **ciudades** - 10 ciudades de México
4. **categorias** - 15 categorías de servicios
5. **planes** - 3 planes (Gratis, Básico, Premium)
6. **empresas** - Perfiles de empresas
7. **servicios** - Servicios ofrecidos
8. **horarios** - Horarios de atención
9. **resenas** - Calificaciones y comentarios
10. **metricas** - Vistas, clics, conversiones
11. **suscripciones** - Suscripciones activas
12. **fotos_empresas** - Galería de fotos
13. **personal_access_tokens** - Tokens API
14. **password_reset_tokens** - Reset de contraseñas

---

## 🎯 Roadmap

### ✅ Fase 1: MVP (Completado)
- [x] Landing Page moderna
- [x] Backend API completo
- [x] Sistema de autenticación
- [x] Búsqueda y filtros
- [x] Sistema de planes
- [x] Métricas básicas
- [x] Sistema de notificaciones
- [x] Alertas de aprobación/rechazo
- [x] Emails automáticos de recordatorio

### 🚧 Fase 2: Dashboard (En desarrollo)
- [ ] Panel para empresas
- [ ] Gestión de servicios
- [ ] Visualización de métricas
- [ ] Sistema de pagos (Stripe)

### 🔮 Fase 3: App Desktop
- [ ] Electron app
- [ ] Notificaciones push
- [ ] Chat en tiempo real
- [ ] Panel offline

---

## 📞 Soporte

### Problemas Comunes

**Error: "Connection refused" en el backend**
- Verifica que MySQL esté corriendo en XAMPP
- Asegúrate de que el archivo `.env` exista
- Revisa que la base de datos `servilocal` esté creada

**Error: "Class not found"**
```bash
composer dump-autoload
```

**Resetear base de datos**
```bash
php artisan migrate:fresh --seed
```

---

## 📄 Licencia

Este proyecto es privado y confidencial.

---

## 🚀 ¡Listo para Lanzar!

Tu sistema ServiLocal está 100% funcional:
- ✅ Landing page profesional
- ✅ Backend API robusto
- ✅ Base de datos optimizada
- ✅ Sistema de monetización
- ✅ Datos de prueba listos

**¡A conquistar el mercado local! 💼💰**

---

**Desarrollado con ❤️ por un Full Stack Developer con 10+ años de experiencia**

