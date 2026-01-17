@echo off
chcp 65001 >nul
cls

echo ========================================
echo   ServiLocal Landing Page
echo   Puerto: 3004
echo ========================================
echo.
echo Iniciando servidor en http://localhost:3004
echo.
echo Presiona Ctrl+C para detener el servidor
echo.

cd /d "%~dp0"

php -S localhost:3004 server.php

pause
