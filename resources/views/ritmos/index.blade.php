@extends('layouts.app')

@section('title', 'Ritmos')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-music-note-list me-2"></i>
            Programa de Ritmos - La Chilinga
        </h2>
        @can('create', App\Models\Ritmo::class)
        <a href="{{ route('ritmos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Crear Ritmo
        </a>
        @endcan
    </div>

    <div class="card-body">
        @php
            // Organizar ritmos por año
            $ritmosPorAnio = [];
            foreach ($ritmos as $ritmo) {
                $anio = $ritmo->anio ?? 'Sin año';
                if (!isset($ritmosPorAnio[$anio])) {
                    $ritmosPorAnio[$anio] = [];
                }
                $ritmosPorAnio[$anio][] = $ritmo;
            }
            ksort($ritmosPorAnio);
        @endphp

        @forelse($ritmosPorAnio as $anio => $ritmosAnio)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="h5 mb-0">
                    <i class="bi bi-calendar3 me-2"></i>
                    @if($anio == 'Sin año')
                        Ritmos sin Año Asignado
                    @else
                        {{ $anio == 1 ? '1er' : ($anio == 2 ? '2do' : ($anio == 3 ? '3er' : ($anio == 4 ? '4to' : ($anio == 5 ? '5to' : ($anio == 6 ? '6to' : $anio))))) }} Año
                    @endif
                    <span class="badge bg-light text-primary ms-2">{{ count($ritmosAnio) }} ritmos</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($ritmosAnio as $ritmo)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-music-note-beamed me-2 text-primary"></i>
                                    {{ $ritmo->nombre }}
                                </h5>
                                
                                @if($ritmo->tipo || $ritmo->autor)
                                <div class="mb-2">
                                    @if($ritmo->tipo)
                                    <span class="badge bg-info me-1">
                                        {{ $ritmo->tipo }}
                                    </span>
                                    @endif
                                    @if($ritmo->autor)
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-person me-1"></i>
                                        {{ $ritmo->autor }}
                                    </small>
                                    @endif
                                    @if($ritmo->opcional)
                                    <span class="badge bg-warning mt-1">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Opcional
                                        @if($ritmo->anio_opcional)
                                        ({{ $ritmo->anio_opcional }})
                                        @endif
                                    </span>
                                    @endif
                                </div>
                                @endif

                                @if($ritmo->descripcion)
                                <p class="card-text text-muted small mb-2">
                                    {{ Str::limit($ritmo->descripcion, 80) }}
                                </p>
                                @endif

                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-speedometer2 me-1"></i>
                                        BPM: {{ $ritmo->bpm_default ?? 120 }}
                                    </span>
                                    @if(!$ritmo->approved)
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock me-1"></i>
                                        Pendiente
                                    </span>
                                    @else
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Aprobado
                                    </span>
                                    @endif
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('ritmos.show', $ritmo) }}" class="btn btn-primary btn-sm flex-fill">
                                        <i class="bi bi-eye me-1"></i>
                                        Ver
                                    </a>
                                    @can('update', $ritmo)
                                    <a href="{{ route('ritmos.edit', $ritmo) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
