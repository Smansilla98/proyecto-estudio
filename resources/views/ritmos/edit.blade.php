@extends('layouts.app')

@section('title', 'Editar Ritmo')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-pencil me-2"></i>
            Editar Ritmo
        </h2>
        <a href="{{ route('ritmos.show', $ritmo) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>
    <div class="card-body">
                <form action="{{ route('ritmos.update', $ritmo) }}" method="POST">
                    @csrf
                    @method('PUT')
            
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    <i class="bi bi-tag me-1"></i>
                    Nombre del Ritmo
                </label>
                <input type="text" name="nombre" id="nombre" required value="{{ old('nombre', $ritmo->nombre) }}" class="form-control" placeholder="Ej: Samba, Bossa Nova, etc.">
                            @error('nombre')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="anio" class="form-label">
                        <i class="bi bi-calendar3 me-1"></i>
                        Año del Programa
                    </label>
                    <select name="anio" id="anio" class="form-select">
                        <option value="">Seleccione un año</option>
                        <option value="1" {{ old('anio', $ritmo->anio) == 1 ? 'selected' : '' }}>1er Año</option>
                        <option value="2" {{ old('anio', $ritmo->anio) == 2 ? 'selected' : '' }}>2do Año</option>
                        <option value="3" {{ old('anio', $ritmo->anio) == 3 ? 'selected' : '' }}>3er Año</option>
                        <option value="4" {{ old('anio', $ritmo->anio) == 4 ? 'selected' : '' }}>4to Año</option>
                        <option value="5" {{ old('anio', $ritmo->anio) == 5 ? 'selected' : '' }}>5to Año</option>
                        <option value="6" {{ old('anio', $ritmo->anio) == 6 ? 'selected' : '' }}>6to Año</option>
                    </select>
                    @error('anio')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                <div class="col-md-6 mb-3">
                    <label for="tipo" class="form-label">
                        <i class="bi bi-tag me-1"></i>
                        Tipo
                    </label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">Seleccione un tipo</option>
                        <option value="Autor" {{ old('tipo', $ritmo->tipo) == 'Autor' ? 'selected' : '' }}>Autor</option>
                        <option value="Ritmo Popular" {{ old('tipo', $ritmo->tipo) == 'Ritmo Popular' ? 'selected' : '' }}>Ritmo Popular</option>
                        <option value="Adaptación" {{ old('tipo', $ritmo->tipo) == 'Adaptación' ? 'selected' : '' }}>Adaptación</option>
                    </select>
                    @error('tipo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="autor" class="form-label">
                        <i class="bi bi-person me-1"></i>
                        Autor / Adaptación
                    </label>
                    <input type="text" name="autor" id="autor" value="{{ old('autor', $ritmo->autor) }}" class="form-control" placeholder="Ej: D. Buira, Ritmo Popular de Brasil, etc.">
                    @error('autor')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                <div class="col-md-6 mb-3">
                    <label for="bpm_default" class="form-label">
                        <i class="bi bi-speedometer2 me-1"></i>
                        BPM por Defecto
                    </label>
                    <input type="number" name="bpm_default" id="bpm_default" required min="60" max="200" value="{{ old('bpm_default', $ritmo->bpm_default) }}" class="form-control" placeholder="120">
                    <small class="text-muted">Beats por minuto (rango: 60-200)</small>
                            @error('bpm_default')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="opcional" id="opcional" value="1" {{ old('opcional', $ritmo->opcional) ? 'checked' : '' }}>
                    <label class="form-check-label" for="opcional">
                        <i class="bi bi-info-circle me-1"></i>
                        Ritmo Opcional
                    </label>
                </div>
                @error('opcional')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="anioOpcionalContainer" style="display: {{ old('opcional', $ritmo->opcional) ? 'block' : 'none' }};">
                <label for="anio_opcional" class="form-label">
                    <i class="bi bi-calendar-range me-1"></i>
                    Años Opcionales
                </label>
                <input type="text" name="anio_opcional" id="anio_opcional" value="{{ old('anio_opcional', $ritmo->anio_opcional) }}" class="form-control" placeholder="Ej: 1er o 2do año, 3er o 4to año">
                <small class="text-muted">Especifica los años alternativos para ritmos opcionales</small>
                @error('anio_opcional')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">
                    <i class="bi bi-text-paragraph me-1"></i>
                    Descripción
                </label>
                <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Describe el ritmo, su origen, características, etc.">{{ old('descripcion', $ritmo->descripcion) }}</textarea>
                @error('descripcion')
                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-drum me-1"></i>
                    Tambores
                </label>
                <div class="border rounded p-3 bg-light">
                    <div class="row g-2">
                                @foreach($tambores as $tambor)
                        <div class="col-md-4 col-sm-6">
                            <div class="form-check p-2 border rounded">
                                <input class="form-check-input" type="checkbox" name="tambores[]" value="{{ $tambor->id }}" id="tambor_{{ $tambor->id }}" {{ $ritmo->tambores->contains($tambor->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tambor_{{ $tambor->id }}">
                                    <i class="bi bi-drum me-1 text-primary"></i>
                                    {{ $tambor->nombre }}
                                    </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                            @error('tambores')
                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('ritmos.show', $ritmo) }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                                Actualizar Ritmo
                            </button>
                    </div>
                </form>
    </div>
</div>

<script>
    // Mostrar/ocultar campo de años opcionales
    document.getElementById('opcional').addEventListener('change', function() {
        const container = document.getElementById('anioOpcionalContainer');
        if (this.checked) {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    });
</script>
@endsection
