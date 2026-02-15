#!/bin/bash
set -e

# Configurar variables por defecto para el servidor
HOST=${HOST:-0.0.0.0}
PORT=${PORT:-8000}

# Asegurar que PORT sea un número entero
PORT=$((PORT))

# Mapear variables de MySQL de Railway a las que Laravel espera
# Railway proporciona: MYSQLHOST, MYSQLPORT, MYSQLDATABASE, MYSQLUSER, MYSQLPASSWORD
# Laravel espera: DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

if [ -n "$MYSQLHOST" ]; then
    export DB_HOST="$MYSQLHOST"
fi

if [ -n "$MYSQLPORT" ]; then
    export DB_PORT="$MYSQLPORT"
fi

if [ -n "$MYSQLDATABASE" ]; then
    export DB_DATABASE="$MYSQLDATABASE"
elif [ -n "$MYSQL_DATABASE" ]; then
    export DB_DATABASE="$MYSQL_DATABASE"
fi

if [ -n "$MYSQLUSER" ]; then
    export DB_USERNAME="$MYSQLUSER"
fi

if [ -n "$MYSQLPASSWORD" ]; then
    export DB_PASSWORD="$MYSQLPASSWORD"
elif [ -n "$MYSQL_ROOT_PASSWORD" ]; then
    export DB_PASSWORD="$MYSQL_ROOT_PASSWORD"
fi

# Si MYSQL_URL está disponible, usarla directamente
if [ -n "$MYSQL_URL" ]; then
    export DB_URL="$MYSQL_URL"
fi

# Asegurar que DB_CONNECTION esté configurada
export DB_CONNECTION=${DB_CONNECTION:-mysql}

# Asegurar que los directorios existen
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Configurar permisos
chown -R www-data:www-data /var/www/html || true
chmod -R 775 /var/www/html/storage || true
chmod -R 775 /var/www/html/bootstrap/cache || true

# Ejecutar migraciones si es necesario (opcional, descomentar si se necesita)
# php artisan migrate --force || true

# Iniciar el servidor
# Usar formato con = y asegurar que PORT es un número
exec php artisan serve --host="${HOST}" --port="${PORT}"

