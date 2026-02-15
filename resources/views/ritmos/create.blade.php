@extends('layouts.app')

@section('title', 'Crear Ritmo')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-plus-circle" style="margin-right: 10px; color: #6366f1;"></i>
            Crear Nuevo Ritmo
        </h2>
        <a href="{{ route('ritmos.index') }}" class="btn" style="background: #6c757d; color: #fff;">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>

    <form action="{{ route('ritmos.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="nombre" class="form-label">
                <i class="fas fa-heading" style="margin-right: 5px; color: #6366f1;"></i>
                Nombre del Ritmo
            </label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                required 
                value="{{ old('nombre') }}" 
                class="form-control"
                placeholder="Ej: Samba, Bossa Nova, etc."
            >
            @error('nombre')
                <div class="error-message" style="color: #ef4444; font-size: 13px; margin-top: 5px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="descripcion" class="form-label">
                <i class="fas fa-align-left" style="margin-right: 5px; color: #6366f1;"></i>
                Descripción
            </label>
            <textarea 
                name="descripcion" 
                id="descripcion" 
                rows="4" 
                class="form-control"
                placeholder="Describe el ritmo, su origen, características, etc."
            >{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="error-message" style="color: #ef4444; font-size: 13px; margin-top: 5px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="bpm_default" class="form-label">
                <i class="fas fa-tachometer-alt" style="margin-right: 5px; color: #6366f1;"></i>
                BPM por Defecto
            </label>
            <input 
                type="number" 
                name="bpm_default" 
                id="bpm_default" 
                required 
                min="60" 
                max="200" 
                value="{{ old('bpm_default', 120) }}" 
                class="form-control"
                placeholder="120"
            >
            <small style="color: #6c757d; font-size: 12px; margin-top: 5px; display: block;">
                Beats por minuto (rango: 60-200)
            </small>
            @error('bpm_default')
                <div class="error-message" style="color: #ef4444; font-size: 13px; margin-top: 5px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-drum" style="margin-right: 5px; color: #6366f1;"></i>
                Tambores
            </label>
            <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; background: #f8fafc;">
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                    @foreach($tambores as $tambor)
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; border-radius: 6px; transition: all 0.3s ease;" 
                               onmouseover="this.style.background='#fff'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)';" 
                               onmouseout="this.style.background='transparent'; this.style.boxShadow='none';">
                            <input 
                                type="checkbox" 
                                name="tambores[]" 
                                value="{{ $tambor->id }}" 
                                style="width: 18px; height: 18px; cursor: pointer; accent-color: #6366f1;"
                                {{ in_array($tambor->id, old('tambores', [])) ? 'checked' : '' }}
                            >
                            <span style="font-size: 14px; color: #495057;">
                                <i class="fas fa-drum" style="margin-right: 5px; color: #6366f1;"></i>
                                {{ $tambor->nombre }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
            @error('tambores')
                <div class="error-message" style="color: #ef4444; font-size: 13px; margin-top: 5px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
            <a href="{{ route('ritmos.index') }}" class="btn" style="background: #6c757d; color: #fff;">
                <i class="fas fa-times"></i>
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Crear Ritmo
            </button>
        </div>
    </form>
</div>
@endsection
