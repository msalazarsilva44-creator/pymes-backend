# 🚀 ServiLocal - Backend Setup

## ✅ Sistema Completo Creado

### 📦 Lo que hemos construido:

1. ✅ **14 Migraciones** - Base de datos completa
2. ✅ **11 Modelos Eloquent** - Con relaciones y scopes
3. ✅ **6 Controladores API** - Auth, Empresas, Categorías, Ciudades, Planes, Reseñas
4. ✅ **Sistema de Autenticación Multi-rol** - Cliente, Empresa, Admin
5. ✅ **25+ Endpoints API** - RESTful con Laravel Sanctum
6. ✅ **6 Seeders** - Datos de prueba listos

---

## 📋 Requisitos Previos

- ✅ PHP 8.2+ (Ya tienes XAMPP con PHP 8.2.12)
- ✅ Composer 2.x (Ya instalado)
- ✅ MySQL (XAMPP)
- ⚠️ Node.js (Opcional, solo para frontend)

---

## 🔧 Instalación Paso a Paso

### 1️⃣ **Iniciar MySQL en XAMPP**

Abre XAMPP Control Panel y arranca:
- ✅ Apache
- ✅ MySQL

### 2️⃣ **Crear Base de Datos**

Abre **phpMyAdmin**: http://localhost/phpmyadmin

Ejecuta este SQL:

```sql
CREATE DATABASE servilocal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3️⃣ **Configurar Variables de Entorno**

Crea un archivo llamado `.env` en la raíz del proyecto con este contenido:

```env
APP_NAME=ServiLocal
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:3004

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=servilocal
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120

# Configuración de Planes
PLAN_FREE_PRICE=0
PLAN_BASIC_PRICE=5
PLAN_PREMIUM_PRICE=10
PLAN_ANNUAL_DISCOUNT=0.10
```

### 4️⃣ **Instalar Dependencias de Laravel**

Abre terminal en la carpeta del proyecto y ejecuta:

```bash
composer install
```

### 5️⃣ **Generar Key de Aplicación**

```bash
php artisan key:generate
```

### 6️⃣ **Ejecutar Migraciones**

```bash
php artisan migrate
```

Deberías ver algo como:
```
INFO  Running migrations.

2024_01_01_000001_create_roles_table ...................... 25ms DONE
2024_01_01_000002_create_users_table ...................... 38ms DONE
... (14 migraciones totales)
```

### 7️⃣ **Ejecutar Seeders (Datos de Prueba)**

```bash
php artisan db:seed
```

Esto creará:
- ✅ 3 Roles (Admin, Empresa, Cliente)
- ✅ 10 Ciudades
- ✅ 15 Categorías de servicios
- ✅ 3 Planes (Gratis, Básico $5, Premium $10)
- ✅ 5 Usuarios de prueba
- ✅ 3 Empresas de prueba con servicios

### 8️⃣ **Iniciar Servidor de Desarrollo**

```bash
php artisan serve --port=8000
```

O para integrarlo con tu landing actual:

```bash
php artisan serve --port=3004
```

---

## 🌐 API Endpoints Disponibles

### 🔓 Públicos (Sin autenticación)

#### Autenticación
- `POST /api/auth/register/cliente` - Registrar cliente
- `POST /api/auth/register/empresa` - Registrar empresa
- `POST /api/auth/login` - Login

#### Búsqueda
- `GET /api/categorias` - Listar categorías
- `GET /api/ciudades` - Listar ciudades
- `GET /api/planes` - Listar planes de suscripción
- `GET /api/empresas` - Buscar empresas (con filtros)
- `GET /api/empresas/{id}` - Ver detalle de empresa
- `POST /api/empresas/{id}/clic` - Registrar clic en contacto

#### Reseñas
- `GET /api/empresas/{id}/resenas` - Ver reseñas de una empresa

### 🔒 Protegidos (Requieren auth:sanctum)

#### Perfil
- `GET /api/auth/me` - Obtener usuario autenticado
- `PUT /api/auth/profile` - Actualizar perfil
- `POST /api/auth/change-password` - Cambiar contraseña
- `POST /api/auth/logout` - Cerrar sesión

#### Empresas (Solo propietario)
- `PUT /api/empresas/{id}` - Actualizar datos de empresa
- `GET /api/empresas/{id}/metricas` - Ver métricas y estadísticas

#### Reseñas (Cliente autenticado)
- `POST /api/empresas/{id}/resenas` - Crear reseña
- `POST /api/resenas/{id}/responder` - Responder reseña (empresa)

---

## 🧪 Probar la API

### Usando cURL (Terminal):

```bash
# Ping test
curl http://localhost:8000/api/ping

# Login como admin
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@servilocal.com","password":"password"}'

# Listar empresas
curl http://localhost:8000/api/empresas

# Buscar por categoría
curl "http://localhost:8000/api/empresas?categoria_id=1"

# Buscar por ciudad
curl "http://localhost:8000/api/empresas?ciudad_id=1"
```

### Usando Postman:

1. Importa la colección o crea requests manualmente
2. Usa las credenciales de prueba:
   - **Admin**: `admin@servilocal.com` / `password`
   - **Cliente**: `cliente@test.com` / `password`
   - **Empresa 1**: `maria@plomeria.com` / `password`

---

## 👥 Usuarios de Prueba

| Rol | Email | Password | Descripción |
|-----|-------|----------|-------------|
| Admin | admin@servilocal.com | password | Administrador del sistema |
| Cliente | cliente@test.com | password | Cliente de prueba |
| Empresa | maria@plomeria.com | password | Plomería Rápida GDL (Plan Premium) |
| Empresa | carlos@electricidad.com | password | Electricidad Segura (Plan Básico) |
| Empresa | ana@carpinteria.com | password | Carpintería Artesanal (Plan Gratis) |

---

## 📊 Estructura de la Base de Datos

### Tablas Principales:

1. **roles** - Admin, Empresa, Cliente
2. **users** - Usuarios del sistema
3. **ciudades** - 10 ciudades disponibles
4. **categorias** - 15 categorías de servicios
5. **planes** - Gratis, Básico ($5), Premium ($10)
6. **empresas** - Perfiles de empresas
7. **fotos_empresas** - Galería de fotos
8. **servicios** - Servicios ofrecidos por empresas
9. **horarios** - Horarios de atención
10. **suscripciones** - Suscripciones activas
11. **resenas** - Calificaciones y comentarios
12. **metricas** - Vistas, clics, conversiones

---

## 🔥 Características Implementadas

### Sistema de Posicionamiento
Las empresas se ordenan automáticamente según su plan:
- **Premium**: posicion_prioridad = 100 (Top 3)
- **Básico**: posicion_prioridad = 50 (Intermedio)
- **Gratis**: posicion_prioridad = 0 (Al final)

### Métricas en Tiempo Real
El sistema registra automáticamente:
- ✅ Vistas de perfil
- ✅ Clics en teléfono
- ✅ Clics en WhatsApp
- ✅ Clics en sitio web
- ✅ Clics en dirección

### Sistema de Reseñas
- ✅ Calificación de 1-5 estrellas
- ✅ Comentarios de clientes
- ✅ Respuesta de la empresa
- ✅ Cálculo automático de promedio

---

## 🚀 Próximos Pasos

### Frontend (Conectar con la Landing)

1. **Integrar API con JavaScript**
   ```javascript
   // Ejemplo de búsqueda
   fetch('http://localhost:8000/api/empresas?ciudad_id=1&categoria_id=1')
     .then(res => res.json())
     .then(data => console.log(data.data));
   ```

2. **Crear Dashboard para Empresas**
   - Ver métricas
   - Gestionar servicios
   - Responder reseñas

3. **Sistema de Pagos**
   - Integrar Stripe/PayPal
   - Procesar suscripciones

4. **Desktop App (Notificaciones)**
   - Electron app
   - WebSockets para notificaciones en tiempo real

---

## 📞 Soporte

Si tienes problemas:

1. Verifica que MySQL esté corriendo en XAMPP
2. Revisa que el archivo `.env` exista
3. Asegúrate de que la base de datos `servilocal` esté creada
4. Ejecuta `php artisan migrate:fresh --seed` para reiniciar

---

## ✨ ¡Listo para Monetizar!

Tu backend está 100% funcional. Ahora puedes:
- ✅ Registrar empresas
- ✅ Sistema de planes funcional
- ✅ Búsqueda con filtros
- ✅ Métricas y ROI
- ✅ Reseñas y calificaciones

**🎯 ¡A conquistar el mercado local!** 🚀💰

