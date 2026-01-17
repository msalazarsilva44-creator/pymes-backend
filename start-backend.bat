@echo off
chcp 65001 >nul
cls

echo ╔════════════════════════════════════════════════════════╗
echo ║                                                        ║
echo ║           ServiLocal Backend API Server                ║
echo ║                                                        ║
echo ╚════════════════════════════════════════════════════════╝
echo.
echo 🚀 Iniciando servidor Laravel...
echo.
echo 📡 API: http://localhost:8000/api
echo 📄 Documentación: BACKEND_SETUP.md
echo.
echo ⚠️  IMPORTANTE: Asegúrate de tener MySQL corriendo en XAMPP
echo.
echo Presiona Ctrl+C para detener el servidor
echo.
echo ────────────────────────────────────────────────────────
echo.

cd /d "%~dp0"

php artisan serve --port=8000

pause

