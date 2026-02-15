@extends('layouts.app')

@section('title', 'Editar Tambor')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-pencil me-2"></i>
            Editar Tambor
        </h2>
        <a href="{{ route('tambores.show', $tambor) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('tambores.update', $tambor) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    <i class="bi bi-tag me-1"></i>
                    Nombre del Tambor
                </label>
                <input type="text" name="nombre" id="nombre" required value="{{ old('nombre', $tambor->nombre) }}" class="form-control" placeholder="Ej: Timbal, Redoblante, etc.">
                @error('nombre')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="form-label">
                    <i class="bi bi-text-paragraph me-1"></i>
                    Descripción
                </label>
                <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Describe el tambor, sus características, etc.">{{ old('descripcion', $tambor->descripcion) }}</textarea>
                @error('descripcion')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('tambores.show', $tambor) }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                    Actualizar Tambor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

