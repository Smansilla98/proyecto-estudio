# 🚀 CONFIGURACIÓN PARA RAILWAY

## 🌐 URL de Producción

**URL Principal**: `https://proyecto-estudio-production.up.railway.app/`

**Panel Admin Filament**: `https://proyecto-estudio-production.up.railway.app/admin`

---

## ⚙️ Variables de Entorno Necesarias

### Variables Básicas
```env
APP_NAME="Escuela de Tambores"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://proyecto-estudio-production.up.railway.app
APP_KEY=base64:... (generar con php artisan key:generate)
```

### Base de Datos (MySQL en Railway)
```env
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

### Storage y Archivos
```env
FILESYSTEM_DISK=public
```

### Sesiones y Cache
```env
SESSION_DRIVER=database
CACHE_STORE=database
```

---

## 📦 Configuración de Archivos

### Storage Link
El enlace simbólico se crea automáticamente en el Dockerfile y docker-entrypoint.sh:
```bash
php artisan storage:link
```

### Directorios Necesarios
- `storage/app/public/partituras/`
- `storage/app/public/videos/`
- `public/storage/` (enlace simbólico)

---

## 🔐 Acceso al Panel Admin

### URL
```
https://proyecto-estudio-production.up.railway.app/admin
```

### Usuarios con Acceso
- Usuarios con rol `admin` o `profesor`
- Configurado en `User::canAccessPanel()`

### Crear Usuario Admin
```bash
php artisan tinker
$user = User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
]);
$user->assignRole('admin');
```

---

## 📊 Resources Disponibles

1. **Ritmos** - `/admin/ritmos`
2. **Tambores** - `/admin/tambores`
3. **Videos** - `/admin/videos`
4. **Partituras** - `/admin/partituras`
5. **Usuarios** - `/admin/users`

---

## 🔧 Configuración de HTTPS

El `AppServiceProvider` ya está configurado para forzar HTTPS en producción:
- Detecta automáticamente cuando está detrás de un proxy
- Fuerza HTTPS en todas las URLs generadas

---

## 📝 Notas Importantes

1. **APP_URL**: Debe estar configurada correctamente para que los enlaces funcionen
2. **Storage**: Los archivos se guardan en `storage/app/public/` y son accesibles vía `/storage/`
3. **Permisos**: Asegurar que los directorios tengan permisos correctos (775)
4. **Enlace Simbólico**: Se crea automáticamente en el Dockerfile

---

## ✅ Checklist de Configuración

- [ ] APP_URL configurada en Railway
- [ ] Variables de base de datos configuradas
- [ ] Storage link creado (automático en Dockerfile)
- [ ] Usuario admin creado
- [ ] Permisos de directorios correctos
- [ ] HTTPS funcionando

---

## 🐛 Solución de Problemas

### Archivos no se muestran
- Verificar que `storage:link` se ejecutó
- Verificar permisos de directorios
- Verificar que `FILESYSTEM_DISK=public`

### URLs incorrectas
- Verificar `APP_URL` en Railway
- Verificar `AppServiceProvider` para HTTPS

### No se puede acceder al panel
- Verificar que el usuario tenga rol `admin` o `profesor`
- Verificar método `canAccessPanel()` en User model

---

**Configuración lista para Railway** 🚀

