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
COPY composer.json composer.lock ./

# Instalar dependencias de Composer (esta capa se cachea si no cambian los archivos)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copiar el resto de los archivos de la aplicación
COPY . .

# Ejecutar scripts de composer si es necesario
RUN composer dump-autoload --optimize

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exponer puerto
EXPOSE 8000

# Comando para iniciar la aplicación
CMD php artisan serve --host=0.0.0.0 --port=8000

