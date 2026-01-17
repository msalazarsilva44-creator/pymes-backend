@echo off
setlocal enabledelayedexpansion

REM Cambiar a UTF-8
chcp 65001 >nul

REM Limpiar pantalla
cls

echo.
echo ========================================
echo.
echo   ServiLocal Landing Page Server
echo.
echo   Puerto: 3004
echo   URL: http://localhost:3004
echo.
echo ========================================
echo.
echo Iniciando... (espera 3 segundos)
echo.

REM Esperar a que se complete la inicialización
timeout /t 3 /nobreak

REM Iniciar PHP
cd /d "%~dp0"
php -S localhost:3004 -t .

pause

