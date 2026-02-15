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

# Esperar a que la base de datos esté disponible (máximo 30 segundos)
echo "Esperando conexión a la base de datos..."
timeout=30
counter=0
db_connected=false

while [ $counter -lt $timeout ] && [ "$db_connected" = false ]; do
    # Intentar conectar usando un script PHP simple
    if php -r "
        try {
            \$host = getenv('DB_HOST') ?: '127.0.0.1';
            \$port = getenv('DB_PORT') ?: '3306';
            \$user = getenv('DB_USERNAME') ?: 'root';
            \$pass = getenv('DB_PASSWORD') ?: '';
            \$db = getenv('DB_DATABASE') ?: '';
            \$dsn = \"mysql:host=\$host;port=\$port\";
            if (\$db) \$dsn .= \";dbname=\$db\";
            \$pdo = new PDO(\$dsn, \$user, \$pass);
            \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            exit(0);
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; then
        echo "✓ Conexión a la base de datos establecida"
        db_connected=true
        break
    fi
    echo "Intentando conectar... ($counter/$timeout)"
    sleep 1
    counter=$((counter + 1))
done

if [ "$db_connected" = false ]; then
    echo "⚠ Advertencia: No se pudo verificar la conexión a la base de datos, continuando..."
fi

# Optimizar Laravel para producción
echo "Optimizando Laravel..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Crear enlace simbólico de storage si no existe
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link || true
fi

# Ejecutar migraciones
echo "Ejecutando migraciones..."
php artisan migrate --force || {
    echo "Error al ejecutar migraciones"
    exit 1
}

# Iniciar el servidor
echo "Iniciando servidor en ${HOST}:${PORT}..."
exec php artisan serve --host="${HOST}" --port="${PORT}"

