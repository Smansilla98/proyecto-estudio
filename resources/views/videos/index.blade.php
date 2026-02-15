@extends('layouts.app')

@section('title', 'Videos')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-play-circle me-2"></i>
            Lista de Videos
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver al Dashboard
        </a>
    </div>
    <div class="card-body">
        @forelse($videos ?? [] as $video)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2">
                            <i class="bi bi-drum me-2 text-primary"></i>
                            {{ $video->tambor->nombre ?? 'Sin tambor' }}
                        </h5>
                        <p class="text-muted mb-2">
                            <i class="bi bi-music-note-beamed me-1"></i>
                            Ritmo: {{ $video->ritmo->nombre ?? 'Sin ritmo' }}
                        </p>
                        <div class="d-flex gap-3">
                            <span class="badge bg-info">
                                <i class="bi bi-list-ol me-1"></i>
                                Orden: {{ $video->orden_ejecucion }}
                            </span>
                            @if($video->url_video)
                            <span class="badge bg-success">
                                <i class="bi bi-link-45deg me-1"></i>
                                URL Externa
                            </span>
                            @else
                            <span class="badge bg-primary">
                                <i class="bi bi-file-earmark-play me-1"></i>
                                Archivo Local
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        @if($video->url_video)
                        <a href="{{ $video->url_video }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="bi bi-play-circle me-1"></i>
                            Ver Video
                        </a>
                        @else
                        <a href="{{ Storage::url($video->archivo_video ?? '') }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="bi bi-play-circle me-1"></i>
                            Ver Video
                        </a>
                        @endif
                        @can('update', $video)
                        <button class="btn btn-success btn-sm" onclick="editVideo({{ $video->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        @endcan
                        @can('delete', $video)
                        <form action="{{ route('videos.destroy', $video) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este video?')">
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
            <i class="bi bi-play-circle" style="font-size: 64px; color: #cfcecd; margin-bottom: 20px;"></i>
            <h3 class="h5 text-muted mb-2">No hay videos disponibles</h3>
            <p class="text-muted mb-4">Los videos se agregan desde los ritmos</p>
            <a href="{{ route('ritmos.index') }}" class="btn btn-primary">
                <i class="bi bi-music-note-list me-2"></i>
                Ver Ritmos
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection

