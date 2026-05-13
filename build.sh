#!/usr/bin/env bash

# Script de inicio para Render — se ejecuta dentro del contenedor Docker antes de levantar Nginx/PHP-FPM

set -e

echo "==> Inyectando variables de entorno en .env..."
[ -n "$DB_HOST" ]      && sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|" .env
[ -n "$DB_PORT" ]      && sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT}|" .env
[ -n "$DB_DATABASE" ]  && sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env
[ -n "$DB_USERNAME" ]  && sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" .env
[ -n "$DB_PASSWORD" ]  && sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env
[ -n "$APP_URL" ]      && sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
[ -n "$FRONTEND_URL" ] && sed -i "s|^FRONTEND_URL=.*|FRONTEND_URL=${FRONTEND_URL}|" .env

echo "==> Generando APP_KEY..."
php artisan key:generate --force

echo "==> Enlazando storage..."
php artisan storage:link || true

echo "==> Ejecutando migraciones..."
if [ "${FRESH_MIGRATE}" = "true" ]; then
    echo "==> FRESH_MIGRATE=true — limpiando y recreando tablas..."
    php artisan migrate:fresh --force --seed
else
    php artisan migrate --force
    echo "==> Ejecutando seeders..."
    php artisan db:seed --force
fi

echo "==> Optimizando para producción..."
php artisan route:cache
php artisan view:cache

echo "==> Iniciando servicios..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
