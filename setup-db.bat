@echo off
chcp 65001 >nul
cls

echo ╔════════════════════════════════════════════════════════╗
echo ║                                                        ║
echo ║        ServiLocal - Configuración de Base de Datos    ║
echo ║                                                        ║
echo ╚════════════════════════════════════════════════════════╝
echo.
echo Este script te ayudará a configurar la base de datos
echo.
echo 📋 PASOS:
echo    1. Generar APP_KEY
echo    2. Ejecutar migraciones
echo    3. Poblar con datos de prueba
echo.

cd /d "%~dp0"

echo ────────────────────────────────────────────────────────
echo 🔑 Paso 1: Generando APP_KEY...
echo ────────────────────────────────────────────────────────
echo.
php artisan key:generate
echo.

echo ────────────────────────────────────────────────────────
echo 📊 Paso 2: Ejecutando migraciones...
echo ────────────────────────────────────────────────────────
echo.
php artisan migrate
echo.

echo ────────────────────────────────────────────────────────
echo 🌱 Paso 3: Poblando base de datos con datos de prueba...
echo ────────────────────────────────────────────────────────
echo.
php artisan db:seed
echo.

echo ╔════════════════════════════════════════════════════════╗
echo ║                                                        ║
echo ║               ✅ CONFIGURACIÓN COMPLETADA               ║
echo ║                                                        ║
echo ╚════════════════════════════════════════════════════════╝
echo.
echo 👥 Usuarios de prueba creados:
echo    📧 Admin:    admin@servilocal.com    / password
echo    📧 Cliente:  cliente@test.com        / password
echo    📧 Empresa:  maria@plomeria.com      / password
echo.
echo 🚀 Ahora puedes ejecutar: start-backend.bat
echo.

pause

