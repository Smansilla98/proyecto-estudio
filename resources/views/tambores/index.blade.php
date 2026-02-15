@extends('layouts.app')

@section('title', 'Tambores')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">
            <i class="bi bi-drum me-2"></i>
            Lista de Tambores
        </h2>
        @can('create', App\Models\Tambor::class)
        <a href="{{ route('tambores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Crear Tambor
        </a>
        @endcan
    </div>
    <div class="card-body">
        @forelse($tambores as $tambor)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2">
                            <i class="bi bi-drum me-2 text-primary"></i>
                            {{ $tambor->nombre }}
                        </h5>
                        <p class="text-muted mb-2">
                            {{ $tambor->descripcion ?? 'Sin descripción' }}
                        </p>
                        <div class="d-flex gap-3">
                            <span class="badge bg-info">
                                <i class="bi bi-music-note-list me-1"></i>
                                {{ $tambor->ritmos_count }} Ritmos
                            </span>
                            <span class="badge bg-success">
                                <i class="bi bi-play-circle me-1"></i>
                                {{ $tambor->videos_count }} Videos
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('tambores.show', $tambor) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>
                            Ver
                        </a>
                        @can('update', $tambor)
                        <a href="{{ route('tambores.edit', $tambor) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-pencil me-1"></i>
                            Editar
                        </a>
                        @endcan
                        @can('delete', $tambor)
                        <form action="{{ route('tambores.destroy', $tambor) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este tambor?')">
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
            <i class="bi bi-drum" style="font-size: 64px; color: #cfcecd; margin-bottom: 20px;"></i>
            <h3 class="h5 text-muted mb-2">No hay tambores disponibles</h3>
            <p class="text-muted mb-4">Comienza creando tu primer tambor</p>
            @can('create', App\Models\Tambor::class)
            <a href="{{ route('tambores.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Crear Primer Tambor
            </a>
            @endcan
        </div>
        @endforelse
    </div>
</div>
@endsection

