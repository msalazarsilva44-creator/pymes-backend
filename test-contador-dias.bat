@echo off
echo ================================
echo PRUEBA: Contador de Dias de Plan
echo ================================
echo.

echo 1. Verificando comando de vencimientos...
php artisan suscripciones:verificar-vencimientos
echo.

echo 2. Verificando configuracion del scheduler...
php artisan schedule:list
echo.

echo ================================
echo Prueba completada
echo ================================
echo.
echo Para probar el contador en el dashboard:
echo 1. Inicia sesion como empresa con plan pago
echo 2. Ve al dashboard: http://localhost:8000/dashboard/empresa
echo 3. Verifica que se muestre el contador de dias restantes
echo.
pause
