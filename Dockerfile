FROM php:8.2-fpm

# Instalar dependencias del sistema y limpiar cache en una sola capa
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar solo archivos necesarios para composer (optimización de cache)
# Nota: composer.lock puede no existir en proyectos nuevos, se generará durante install
COPY composer.json ./

# Instalar dependencias de Composer (esta capa se cachea si no cambian los archivos)
# Si composer.lock no existe, composer lo generará automáticamente
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copiar el resto de los archivos de la aplicación
COPY . .

# Crear directorios necesarios y configurar permisos antes de ejecutar composer
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Configurar variable de entorno para composer y ejecutar scripts
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer dump-autoload --optimize

# Copiar script de inicio
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Variables de entorno para el servidor
ENV PORT=8000
ENV HOST=0.0.0.0

# Exponer puerto
EXPOSE 8000

# Usar script de inicio
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

