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
    libicu-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd zip intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configurar límites de PHP para archivos grandes (200MB+)
RUN echo "upload_max_filesize = 200M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 200M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

# Instalar Node.js (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Configurar Composer para ignorar avisos de seguridad temporalmente
# (Esto permite instalar Filament mientras se resuelven los avisos)
RUN composer config --global audit.ignore '{"PKSA-jyd3-2srm-pfqd": "*", "PKSA-1ds2-yqqr-64g1": "*"}' || true

# Copiar solo archivos necesarios para composer (optimización de cache)
# Nota: composer.lock puede no existir en proyectos nuevos, se generará durante install
COPY composer.json ./

# Instalar dependencias de Composer (esta capa se cachea si no cambian los archivos)
# Si composer.lock no existe, composer lo generará automáticamente
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copiar el resto de los archivos de la aplicación (necesarios para compilar assets)
COPY . .

# Crear directorios necesarios ANTES de ejecutar scripts de Laravel
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/app/public/partituras \
    && mkdir -p /var/www/html/storage/app/public/videos \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Configurar variable de entorno para composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Ejecutar dump-autoload sin scripts (evita ejecutar package:discover durante el build)
# package:discover se ejecutará en docker-entrypoint.sh cuando todo esté configurado
RUN composer dump-autoload --optimize --no-scripts

# Instalar dependencias de Node.js y compilar assets de Vite
RUN npm ci || npm install \
    && npm run build \
    && rm -rf node_modules

# Crear enlace simbólico de storage (también se ejecuta en docker-entrypoint.sh por si acaso)
RUN php artisan storage:link || true

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

