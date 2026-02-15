@extends('layouts.app')

@section('title', 'Crear Ritmo')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-plus-circle me-2"></i>
            Crear Nuevo Ritmo
        </h2>
        <a href="{{ route('ritmos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('ritmos.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    <i class="bi bi-tag me-1"></i>
                    Nombre del Ritmo
                </label>
                <input type="text" name="nombre" id="nombre" required value="{{ old('nombre') }}" class="form-control" placeholder="Ej: Samba, Bossa Nova, etc.">
                @error('nombre')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">
                    <i class="bi bi-text-paragraph me-1"></i>
                    Descripción
                </label>
                <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Describe el ritmo, su origen, características, etc.">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bpm_default" class="form-label">
                    <i class="bi bi-speedometer2 me-1"></i>
                    BPM por Defecto
                </label>
                <input type="number" name="bpm_default" id="bpm_default" required min="60" max="200" value="{{ old('bpm_default', 120) }}" class="form-control" placeholder="120">
                <small class="text-muted">Beats por minuto (rango: 60-200)</small>
                @error('bpm_default')
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
                                <input class="form-check-input" type="checkbox" name="tambores[]" value="{{ $tambor->id }}" id="tambor_{{ $tambor->id }}" {{ in_array($tambor->id, old('tambores', [])) ? 'checked' : '' }}>
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
                <a href="{{ route('ritmos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                    Crear Ritmo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
