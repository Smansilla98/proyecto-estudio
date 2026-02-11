# 🥁 Plataforma Web - Escuela de Tambores

Plataforma web tipo Coursera para una escuela de tambores desarrollada con Laravel 11, MySQL y preparada para desplegarse en Railway.

## 🎯 Características

- **Sistema de usuarios y roles**: Admin, Profesor y Alumno con permisos diferenciados
- **Gestión de ritmos**: CRUD completo de ritmos con aprobación de contenido
- **Reproductor múltiple**: Videos sincronizados por tambor con controles individuales
- **Metrónomo integrado**: Metrónomo web con Web Audio API
- **Gestión de archivos**: Almacenamiento en S3/Cloudflare R2
- **Interfaz moderna**: Diseño con Tailwind CSS

## 📋 Requisitos

- PHP >= 8.2
- Composer
- Node.js y npm
- MySQL >= 8.0
- Servicio de almacenamiento S3 compatible (AWS S3, Cloudflare R2, etc.)

## 🚀 Instalación Local

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd proyecto-estudio
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar el archivo `.env` con tus configuraciones:

```env
APP_NAME="Escuela de Tambores"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=escuela_tambores
DB_USERNAME=root
DB_PASSWORD=tu_password

# Configuración S3 (o usar 'local' para desarrollo)
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=tu_access_key
AWS_SECRET_ACCESS_KEY=tu_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=tu_bucket
AWS_ENDPOINT=  # Para Cloudflare R2: https://<account-id>.r2.cloudflarestorage.com
```

### 5. Crear la base de datos

```bash
mysql -u root -p
CREATE DATABASE escuela_tambores;
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

### 7. Compilar assets

```bash
npm run dev
# O para producción:
npm run build
```

### 8. Iniciar el servidor

```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 👥 Usuarios de Prueba

Después de ejecutar los seeders, tendrás los siguientes usuarios:

- **Admin**: 
  - Email: `admin@escuela.com`
  - Password: `password`

- **Profesor**: 
  - Email: `profesor@escuela.com`
  - Password: `password`

- **Alumnos**: 
  - Email: `alumno1@escuela.com`, `alumno2@escuela.com`, `alumno3@escuela.com`
  - Password: `password`

## 🧪 Ejecutar Tests

```bash
php artisan test
```

## 🐳 Despliegue en Railway

### 1. Preparar el proyecto

Asegúrate de que todos los archivos estén en el repositorio:

- `Dockerfile`
- `railway.json`
- `.env.example`

### 2. Conectar con Railway

1. Crea una cuenta en [Railway](https://railway.app)
2. Crea un nuevo proyecto
3. Conecta tu repositorio de GitHub/GitLab

### 3. Configurar variables de entorno en Railway

En el panel de Railway, agrega las siguientes variables de entorno:

```
APP_NAME=Escuela de Tambores
APP_ENV=production
APP_DEBUG=false
APP_KEY=  # Generar con: php artisan key:generate --show
APP_URL=https://tu-app.railway.app

DB_CONNECTION=mysql
DB_HOST=  # Proporcionado por Railway MySQL
DB_PORT=  # Proporcionado por Railway MySQL
DB_DATABASE=  # Proporcionado por Railway MySQL
DB_USERNAME=  # Proporcionado por Railway MySQL
DB_PASSWORD=  # Proporcionado por Railway MySQL

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=tu_access_key
AWS_SECRET_ACCESS_KEY=tu_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=tu_bucket
AWS_ENDPOINT=  # Si usas Cloudflare R2
```

### 4. Agregar servicio MySQL

1. En Railway, agrega un nuevo servicio MySQL
2. Railway proporcionará automáticamente las variables `DB_HOST`, `DB_PORT`, etc.

### 5. Configurar el despliegue

Railway detectará automáticamente el `Dockerfile` y `railway.json`.

### 6. Ejecutar migraciones

Después del primer despliegue, ejecuta las migraciones:

```bash
railway run php artisan migrate --force
railway run php artisan db:seed --force
```

O desde el panel de Railway, abre la consola y ejecuta:

```bash
php artisan migrate --force
php artisan db:seed --force
```

## 📁 Estructura del Proyecto

```
proyecto-estudio/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controladores
│   │   └── Middleware/      # Middleware personalizado
│   ├── Models/              # Modelos Eloquent
│   ├── Policies/            # Policies de autorización
│   ├── Repositories/        # Repositorios para acceso a datos
│   └── Services/            # Servicios de lógica de negocio
├── config/                  # Archivos de configuración
├── database/
│   ├── migrations/          # Migraciones
│   ├── seeders/             # Seeders
│   └── factories/           # Factories para tests
├── resources/
│   ├── views/               # Vistas Blade
│   ├── css/                 # Estilos CSS
│   └── js/                  # JavaScript (reproductor, metrónomo)
├── routes/                  # Rutas
├── tests/                   # Tests
├── Dockerfile               # Configuración Docker
└── railway.json             # Configuración Railway
```

## 🔐 Roles y Permisos

### Admin
- CRUD completo de ritmos, videos, partituras y usuarios
- Asignar roles
- Aprobar contenido subido por profesores

### Profesor
- Crear, editar y eliminar ritmos propios
- Subir videos y partituras
- Ver métricas básicas de visualización

### Alumno
- Ver y reproducir contenido aprobado
- No puede subir ni editar material

## 🎵 Funcionalidades del Reproductor

- Reproducción sincronizada de múltiples videos
- Controles individuales por tambor:
  - Play/Pause
  - Volumen
  - Mute
- Selector de velocidad (0.5x, 1x, 1.25x, 1.5x)
- Metrónomo integrado con BPM configurable

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 11
- **Base de datos**: MySQL
- **Frontend**: Blade + Tailwind CSS
- **Autenticación**: Laravel Breeze (implementación personalizada)
- **Roles y Permisos**: Spatie Laravel Permission
- **Storage**: AWS S3 / Cloudflare R2
- **Metrónomo**: Web Audio API
- **Tests**: PHPUnit

## 📝 Notas Adicionales

- Los videos y PDFs se almacenan en S3/R2. Asegúrate de configurar correctamente las credenciales.
- El metrónomo requiere un navegador moderno con soporte para Web Audio API.
- Para desarrollo local, puedes usar `FILESYSTEM_DISK=local` en lugar de S3.

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

