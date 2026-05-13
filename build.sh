#!/usr/bin/env bash

set -e

echo "==> Instalando dependencias..."
composer install --no-dev --optimize-autoloader

echo "==> Generando APP_KEY..."
php artisan key:generate --force

echo "==> Limpiando caché..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "==> Ejecutando migraciones..."
php artisan migrate --force

echo "==> Ejecutando seeders..."
php artisan db:seed --force

echo "==> Enlazando storage..."
php artisan storage:link

echo "==> Optimizando..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Deploy completado!"
