@extends('layouts.app')

@section('title', $tambore->nombre)

@section('content')
<!-- Header del Tambor -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-drum me-2"></i>
                {{ $tambore->nombre }}
            </h1>
            <p class="text-muted mb-0">{{ $tambore->descripcion ?? 'Sin descripción' }}</p>
        </div>
        <div class="d-flex gap-2">
            @can('update', $tambore)
            <a href="{{ route('tambores.edit', $tambore) }}" class="btn btn-success">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            @endcan
            <a href="{{ route('tambores.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-music-note-list text-primary fs-5"></i>
                    <div>
                        <small class="text-muted d-block">Ritmos</small>
                        <strong>{{ $tambore->ritmos->count() }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-play-circle text-primary fs-5"></i>
                    <div>
                        <small class="text-muted d-block">Videos</small>
                        <strong>{{ $tambore->videos->count() }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar text-primary fs-5"></i>
                    <div>
                        <small class="text-muted d-block">Fecha</small>
                        <strong>{{ $tambore->created_at->format('d/m/Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ritmos que usan este tambor -->
@if($tambore->ritmos->count() > 0)
<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-music-note-list me-2"></i>
            Ritmos que usan este tambor
        </h2>
    </div>
    <div class="card-body">
        <div class="list-group">
            @foreach($tambore->ritmos as $ritmo)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-music-note-beamed text-primary me-2"></i>
                    <a href="{{ route('ritmos.show', $ritmo) }}" class="text-decoration-none">
                        <strong>{{ $ritmo->nombre }}</strong>
                    </a>
                    <small class="text-muted ms-2">BPM: {{ $ritmo->bpm_default }}</small>
                </div>
                <a href="{{ route('ritmos.show', $ritmo) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-eye me-1"></i>
                    Ver Ritmo
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Videos de este tambor -->
@if($tambore->videos->count() > 0)
<div class="card">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-play-circle me-2"></i>
            Videos de este tambor
        </h2>
    </div>
    <div class="card-body">
        <div class="list-group">
            @foreach($tambore->videos as $video)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-play-circle text-primary me-2"></i>
                    <strong>Ritmo: {{ $video->ritmo->nombre ?? 'Sin ritmo' }}</strong>
                    <small class="text-muted ms-2">Orden: {{ $video->orden_ejecucion }}</small>
                </div>
                <div class="d-flex gap-2">
                    @if($video->url_video)
                    <a href="{{ $video->url_video }}" target="_blank" class="btn btn-sm btn-primary">
                        <i class="bi bi-play-circle me-1"></i>
                        Ver Video
                    </a>
                    @else
                    <a href="{{ Storage::url($video->archivo_video ?? '') }}" target="_blank" class="btn btn-sm btn-primary">
                        <i class="bi bi-play-circle me-1"></i>
                        Ver Video
                    </a>
                    @endif
                    <a href="{{ route('ritmos.show', $video->ritmo) }}" class="btn btn-sm btn-info">
                        <i class="bi bi-arrow-right me-1"></i>
                        Ver Ritmo
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

