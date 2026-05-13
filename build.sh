#!/usr/bin/env bash

# Script de inicio para Render — se ejecuta dentro del contenedor Docker antes de levantar Nginx/PHP-FPM

set -e

echo "==> Generando APP_KEY si no existe..."
php artisan key:generate --force

echo "==> Enlazando storage..."
php artisan storage:link || true

echo "==> Ejecutando migraciones..."
php artisan migrate --force

echo "==> Ejecutando seeders..."
php artisan db:seed --force

echo "==> Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Iniciando servicios..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
