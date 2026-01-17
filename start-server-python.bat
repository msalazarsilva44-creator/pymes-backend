@echo off
chcp 65001 >nul
echo ========================================
echo   ServiLocal Landing Page Server
echo   Puerto: 3004
echo ========================================
echo.
echo Iniciando servidor en http://localhost:3004
echo Presiona Ctrl+C para detener el servidor
echo.

cd /d "%~dp0"

python -m http.server 3004

pause

