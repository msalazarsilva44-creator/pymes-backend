@echo off
echo ================================
echo PRUEBA: Sistema de Emails
echo ================================
echo.

echo 1. Verificando configuracion de correo...
php artisan config:show mail
echo.

echo 2. Verificando comando de recordatorios...
php artisan suscripciones:enviar-recordatorios
echo.

echo 3. Ver tareas programadas...
php artisan schedule:list | findstr "recordatorios"
echo.

echo ================================
echo Prueba completada
echo ================================
echo.
echo Para configurar el correo:
echo 1. Abre: CONFIGURAR_EMAILS_RAPIDO.md
echo 2. Sigue los pasos para Mailtrap
echo 3. Ejecuta este script de nuevo
echo.
pause
