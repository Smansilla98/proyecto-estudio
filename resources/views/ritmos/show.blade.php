@extends('layouts.app')

@section('title', $ritmo->nombre)

@section('content')
<!-- Header del Ritmo -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-music-note-beamed me-2"></i>
                {{ $ritmo->nombre }}
            </h1>
            <p class="text-muted mb-0">{{ $ritmo->descripcion }}</p>
        </div>
        <div class="d-flex gap-2">
            @can('update', $ritmo)
            <a href="{{ route('ritmos.edit', $ritmo) }}" class="btn btn-success">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            @endcan
            @can('approve', $ritmo)
            @if(!$ritmo->approved)
            <form action="{{ route('ritmos.approve', $ritmo) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>
                    Aprobar
                </button>
            </form>
            @else
            <span class="badge bg-success">
                <i class="bi bi-check-circle me-1"></i>
                Aprobado
            </span>
            @endif
            @endcan
            <a href="{{ route('ritmos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-speedometer2 text-primary fs-5"></i>
                    <div>
                        <small class="text-muted d-block">BPM</small>
                        <strong>{{ $ritmo->bpm_default }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-person text-primary fs-5"></i>
                    <div>
                        <small class="text-muted d-block">Creado por</small>
                        <strong>{{ $ritmo->creador->name }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar text-primary fs-5"></i>
                    <div>
                        <small class="text-muted d-block">Fecha</small>
                        <strong>{{ $ritmo->created_at->format('d/m/Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambores -->
<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-drum me-2"></i>
            Tambores
        </h2>
    </div>
    <div class="card-body">
        @if($ritmo->tambores->count() > 0)
        <div class="d-flex flex-wrap gap-2">
            @foreach($ritmo->tambores as $tambor)
            <span class="badge bg-primary fs-6 px-3 py-2">
                <i class="bi bi-drum me-1"></i>
                {{ $tambor->nombre }}
            </span>
            @endforeach
        </div>
        @else
        <p class="text-muted mb-0">No hay tambores asignados a este ritmo.</p>
        @endif
    </div>
</div>

<!-- Videos -->
@if($ritmo->videos->count() > 0)
<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-play-circle me-2"></i>
            Videos
        </h2>
    </div>
    <div class="card-body">
        <div id="video-player-container" data-ritmo-id="{{ $ritmo->id }}" data-bpm="{{ $ritmo->bpm_default }}">
            @include('ritmos.video-player', ['ritmo' => $ritmo])
        </div>
    </div>
</div>
@endif

<!-- Agregar Video -->
@can('create', App\Models\Video::class)
<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-plus-circle me-2"></i>
            Agregar Video
        </h2>
    </div>
    <div class="card-body">
        <form action="{{ route('videos.store', $ritmo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="tambor_id" class="form-label">Tambor</label>
                    <select name="tambor_id" id="tambor_id" required class="form-select">
                        <option value="">Seleccione un tambor</option>
                        @foreach($ritmo->tambores as $tambor)
                        <option value="{{ $tambor->id }}">{{ $tambor->nombre }}</option>
                        @endforeach
                    </select>
                    @error('tambor_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="orden_ejecucion" class="form-label">Orden de Ejecución</label>
                    <input type="number" name="orden_ejecucion" id="orden_ejecucion" value="0" required min="0" class="form-control">
                    @error('orden_ejecucion')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="url_video" class="form-label">URL del Video (opcional)</label>
                    <input type="url" name="url_video" id="url_video" class="form-control" placeholder="https://...">
                    @error('url_video')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="video_file" class="form-label">Archivo de Video (opcional)</label>
                    <input type="file" name="video_file" id="video_file" accept="video/*" class="form-control">
                    <small class="text-muted">Formatos: MP4, WebM, OGG (máx. 100MB)</small>
                    @error('video_file')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Agregar Video
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcan

<!-- Partituras -->
@if($ritmo->partituras->count() > 0)
<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-file-earmark-music me-2"></i>
            Partituras
        </h2>
    </div>
    <div class="card-body">
        <div class="list-group">
            @foreach($ritmo->partituras as $partitura)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                    <span>Partitura PDF</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ filter_var($partitura->archivo_pdf, FILTER_VALIDATE_URL) ? $partitura->archivo_pdf : (config('filesystems.default') === 's3' ? Storage::disk('s3')->url($partitura->archivo_pdf) : Storage::url($partitura->archivo_pdf)) }}" 
                       target="_blank" 
                       class="btn btn-sm btn-primary">
                        <i class="bi bi-download me-1"></i>
                        Descargar
                    </a>
                    @can('delete', $partitura)
                    <form action="{{ route('partituras.destroy', $partitura) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta partitura?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Agregar Partitura -->
@can('create', App\Models\Partitura::class)
<div class="card">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-plus-circle me-2"></i>
            Agregar Partitura
        </h2>
    </div>
    <div class="card-body">
        <form action="{{ route('partituras.store', $ritmo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="archivo_pdf" class="form-label">Archivo PDF</label>
                <input type="file" name="archivo_pdf" id="archivo_pdf" accept=".pdf" required class="form-control">
                <small class="text-muted">Formato: PDF (máx. 10MB)</small>
                @error('archivo_pdf')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Agregar Partitura
            </button>
        </form>
    </div>
</div>
@endcan
@endsection
