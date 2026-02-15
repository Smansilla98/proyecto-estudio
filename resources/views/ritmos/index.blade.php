@extends('layouts.app')

@section('title', 'Ritmos')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-music-note-list me-2"></i>
            Lista de Ritmos
        </h2>
        @can('create', App\Models\Ritmo::class)
        <a href="{{ route('ritmos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Crear Ritmo
        </a>
        @endcan
    </div>

    <div class="card-body">
        @forelse($ritmos as $ritmo)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-grow-1">
                        <h3 class="h5 mb-2">
                            <i class="bi bi-drum me-2 text-primary"></i>
                            {{ $ritmo['nombre'] }}
                        </h3>
                        <p class="text-muted mb-3">
                            {{ $ritmo['descripcion'] ?? 'Sin descripción' }}
                        </p>
                        <div class="d-flex gap-3 flex-wrap align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-speedometer2 text-primary"></i>
                                <span class="text-muted">
                                    <strong>BPM:</strong> {{ $ritmo['bpm_default'] }}
                                </span>
                            </div>
                            @if(!$ritmo['approved'])
                            <span class="badge bg-warning">
                                <i class="bi bi-clock me-1"></i>
                                Pendiente de Aprobación
                            </span>
                            @else
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Aprobado
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('ritmos.show', $ritmo['id']) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>
                            Ver
                        </a>
                        @can('update', App\Models\Ritmo::class)
                        <a href="{{ route('ritmos.edit', $ritmo['id']) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-pencil me-1"></i>
                            Editar
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-music-note-list" style="font-size: 64px; color: #cfcecd; margin-bottom: 20px;"></i>
            <h3 class="h5 text-muted mb-2">No hay ritmos disponibles</h3>
            <p class="text-muted mb-4">Comienza creando tu primer ritmo</p>
            @can('create', App\Models\Ritmo::class)
            <a href="{{ route('ritmos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Crear Primer Ritmo
            </a>
            @endcan
        </div>
        @endforelse
    </div>
</div>
@endsection
