@extends('layouts.app')

@section('title', 'Partituras')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-file-earmark-music me-2"></i>
            Lista de Partituras
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver al Dashboard
        </a>
    </div>
    <div class="card-body">
        @forelse($partituras ?? [] as $partitura)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2">
                            <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                            Partitura PDF
                        </h5>
                        <p class="text-muted mb-2">
                            <i class="bi bi-music-note-beamed me-1"></i>
                            Ritmo: {{ $partitura->ritmo->nombre ?? 'Sin ritmo' }}
                        </p>
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            Creada: {{ $partitura->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('partituras.show', $partitura) }}" 
                           class="btn btn-success btn-sm">
                            <i class="bi bi-play-circle me-1"></i>
                            Ver/Reproducir
                        </a>
                        <a href="{{ filter_var($partitura->archivo_pdf, FILTER_VALIDATE_URL) ? $partitura->archivo_pdf : (config('filesystems.default') === 's3' ? Storage::disk('s3')->url($partitura->archivo_pdf) : Storage::url($partitura->archivo_pdf)) }}" 
                           target="_blank" 
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-download me-1"></i>
                            Descargar PDF
                        </a>
                        @can('update', $partitura)
                        <button class="btn btn-warning btn-sm" onclick="editPartitura({{ $partitura->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        @endcan
                        @can('delete', $partitura)
                        <form action="{{ route('partituras.destroy', $partitura) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta partitura?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-file-earmark-music" style="font-size: 64px; color: #cfcecd; margin-bottom: 20px;"></i>
            <h3 class="h5 text-muted mb-2">No hay partituras disponibles</h3>
            <p class="text-muted mb-4">Las partituras se agregan desde los ritmos</p>
            <a href="{{ route('ritmos.index') }}" class="btn btn-primary">
                <i class="bi bi-music-note-list me-2"></i>
                Ver Ritmos
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection

