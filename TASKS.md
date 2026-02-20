# 📋 PLAN DE TRABAJO - PROYECTO ESTUDIO

## ✅ TAREA COMPLETADA

### 🔧 Aumentar límites de subida de archivos
- **Estado**: ✅ Completado
- **Cambios realizados**:
  - PDFs: 10MB → 100MB
  - Videos: 100MB → 200MB
  - Configuración PHP en Dockerfile para soportar archivos grandes
  - Actualización de mensajes de error y vistas

---

## 🔥 PRIORIDAD CRÍTICA (Alta Prioridad)

### TASK-001: Sistema de Progreso del Alumno
**Descripción**: Implementar seguimiento de progreso por ritmo/lección
**Criterios de aceptación**:
- [ ] Crear migración `progress_tracking` table
- [ ] Modelo `Progress` con relaciones
- [ ] Registrar progreso cuando alumno ve/reproduce contenido
- [ ] Mostrar % completado en dashboard
- [ ] Mostrar progreso en listas de ritmos
- [ ] API endpoint para actualizar progreso

**Archivos a crear/modificar**:
- `database/migrations/xxxx_create_progress_table.php`
- `app/Models/Progress.php`
- `app/Http/Controllers/ProgressController.php`
- `app/Services/ProgressService.php`
- `resources/views/dashboard.blade.php`
- `resources/views/ritmos/index.blade.php`

---

### TASK-002: Mejorar UX del Dashboard
**Descripción**: Rediseñar dashboard con tarjetas y mejor visualización
**Criterios de aceptación**:
- [ ] Tarjetas visuales para ritmos/cursos
- [ ] Indicadores de "lecciones por terminar"
- [ ] Actividad reciente visible
- [ ] Progreso visual (barras de progreso)
- [ ] Diseño responsive

**Archivos a modificar**:
- `resources/views/dashboard.blade.php`
- `resources/css/app.css` (o crear `dashboard.css`)
- `app/Http/Controllers/DashboardController.php`

---

### TASK-003: Documentación Completa
**Descripción**: Completar README y documentación del proyecto
**Criterios de aceptación**:
- [ ] README completo con:
  - Flujo de roles (alumno/profesor/admin)
  - Endpoints API documentados
  - Guía de contribución
  - Contenido del reproductor interactivo
- [ ] Crear `.env.example` completo
- [ ] Documentar variables de entorno (S3/R2)
- [ ] Guía de tests

**Archivos a crear/modificar**:
- `README.md`
- `.env.example`
- `docs/API.md`
- `docs/CONTRIBUTING.md`
- `docs/TESTING.md`

---

### TASK-004: Refinar Autorización (Policies)
**Descripción**: Mejorar y completar Policies de Laravel
**Criterios de aceptación**:
- [ ] Revisar todas las Policies existentes
- [ ] Añadir Policies faltantes
- [ ] Tests de autorización
- [ ] Documentar permisos por rol

**Archivos a modificar**:
- `app/Policies/*.php`
- `tests/Feature/PoliciesTest.php`

---

## ⚙️ PRIORIDAD MEDIA

### TASK-005: Tests Automatizados
**Descripción**: Implementar suite de tests
**Criterios de aceptación**:
- [ ] Tests unitarios para Services
- [ ] Tests de feature para:
  - Usuarios y roles
  - Acceso a ritmos
  - Reproductor
  - Control de progreso
- [ ] Coverage mínimo 70%

**Archivos a crear**:
- `tests/Unit/Services/*Test.php`
- `tests/Feature/AuthTest.php`
- `tests/Feature/RitmosTest.php`
- `tests/Feature/ProgressTest.php`
- `phpunit.xml` (configurar)

---

### TASK-006: Mejorar Docker/CI-CD
**Descripción**: Mejorar soporte Docker y CI/CD
**Criterios de aceptación**:
- [ ] Crear `docker-compose.yml`
- [ ] Contenedores: web / db / queue
- [ ] Scripts para ejecutar tests en Docker
- [ ] GitHub Actions workflow:
  - Linting PHP & JS
  - Build & test on PR
  - Deploy to staging

**Archivos a crear**:
- `docker-compose.yml`
- `.github/workflows/ci.yml`
- `scripts/test-docker.sh`

---

### TASK-007: Mejoras al Reproductor
**Descripción**: Añadir funcionalidades avanzadas al reproductor
**Criterios de aceptación**:
- [ ] Loop por sección
- [ ] Repetición automática de compases
- [ ] Indicador visual de compás actual
- [ ] Control de velocidad por pista independiente
- [ ] Mejorar visualización multi-pista

**Archivos a modificar**:
- `resources/views/partituras/show.blade.php`
- `resources/js/partitura-player.js` (crear si no existe)

---

### TASK-008: Refactorizar Controladores
**Descripción**: Extraer lógica de negocio a Services
**Criterios de aceptación**:
- [ ] Revisar controladores grandes
- [ ] Mover lógica a Services/Repositories
- [ ] Controladores solo para HTTP concerns
- [ ] Tests para Services refactorizados

**Archivos a modificar**:
- `app/Http/Controllers/*.php`
- `app/Services/*.php`
- `app/Repositories/*.php`

---

## 🚀 PRIORIDAD AVANZADA (Futuro)

### TASK-009: Soporte MIDI Completo
**Descripción**: Importar y mapear archivos MIDI
**Criterios de aceptación**:
- [ ] Parser MIDI
- [ ] Mapeo a ritmos
- [ ] Visualización en partitura
- [ ] Exportación mejorada

---

### TASK-010: Gamificación
**Descripción**: Sistema de puntos, badges y leaderboard
**Criterios de aceptación**:
- [ ] Modelo de puntos
- [ ] Sistema de badges
- [ ] Leaderboard
- [ ] Rachas de práctica

---

### TASK-011: Analíticas para Admin/Profesor
**Descripción**: Dashboard de analíticas
**Criterios de aceptación**:
- [ ] Tasa de finalización
- [ ] Tiempo de práctica
- [ ] Ritmos más reproducidos
- [ ] Gráficos y métricas

---

### TASK-012: Feedback de Práctica
**Descripción**: Sistema de notas y feedback
**Criterios de aceptación**:
- [ ] Notas de profesores
- [ ] Anotaciones de alumnos
- [ ] Historial de feedback
- [ ] Notificaciones

---

### TASK-013: Breadcrumbs y Navegación
**Descripción**: Mejorar navegación del sitio
**Criterios de aceptación**:
- [ ] Componente breadcrumbs
- [ ] Navegación clara
- [ ] Mejor UX en cursos largos

---

### TASK-014: Simplificar Formularios
**Descripción**: Mejorar UX de formularios de profesor
**Criterios de aceptación**:
- [ ] Formularios más intuitivos
- [ ] Menos pasos
- [ ] Validación en tiempo real
- [ ] Preview antes de guardar

---

## 🧹 CLEANUP

### TASK-015: Limpieza de Código
**Descripción**: Eliminar archivos innecesarios
**Criterios de aceptación**:
- [ ] Revisar assets sin uso
- [ ] Eliminar controladores vacíos
- [ ] Limpiar routes duplicadas
- [ ] Optimizar dependencias

---

## 📊 TRACKING

### Progreso General
- ✅ Completadas: 1/15
- 🔄 En progreso: 0/15
- ⏳ Pendientes: 14/15

### Próximos Pasos Recomendados
1. **TASK-001**: Sistema de Progreso (Crítico)
2. **TASK-002**: Mejorar Dashboard (Crítico)
3. **TASK-003**: Documentación (Crítico)
4. **TASK-005**: Tests básicos (Medio)

---

## 📝 NOTAS

- Priorizar tareas críticas antes de avanzadas
- Cada tarea debe tener tests asociados
- Documentar cambios importantes
- Mantener código limpio y refactorizado

