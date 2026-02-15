@extends('layouts.app')

@section('title', 'Ritmos')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-music" style="margin-right: 10px; color: #6366f1;"></i>
            Lista de Ritmos
        </h2>
        @can('create', App\Models\Ritmo::class)
        <a href="{{ route('ritmos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Crear Ritmo
        </a>
        @endcan
    </div>

    @forelse($ritmos as $ritmo)
    <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 15px; transition: all 0.3s ease;" 
         onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'; this.style.transform='translateY(-2px)';" 
         onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
            <div style="flex: 1;">
                <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 8px;">
                    <i class="fas fa-drum" style="color: #6366f1; margin-right: 8px;"></i>
                    {{ $ritmo['nombre'] }}
                </h3>
                <p style="color: #6c757d; margin-bottom: 12px;">
                    {{ $ritmo['descripcion'] ?? 'Sin descripción' }}
                </p>
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-tachometer-alt" style="color: #6366f1;"></i>
                        <span style="font-size: 14px; color: #6c757d;">
                            <strong>BPM:</strong> {{ $ritmo['bpm_default'] }}
                        </span>
                    </div>
                    @if(!$ritmo['approved'])
                    <span class="badge badge-warning">
                        <i class="fas fa-clock" style="margin-right: 5px;"></i>
                        Pendiente de Aprobación
                    </span>
                    @else
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                        Aprobado
                    </span>
                    @endif
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('ritmos.show', $ritmo['id']) }}" class="btn" style="background: #6366f1; color: #fff; padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-eye"></i>
                    Ver
                </a>
                @can('update', App\Models\Ritmo::class)
                <a href="{{ route('ritmos.edit', $ritmo['id']) }}" class="btn" style="background: #10b981; color: #fff; padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                @endcan
            </div>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 60px 20px;">
        <i class="fas fa-music" style="font-size: 64px; color: #e0e0e0; margin-bottom: 20px;"></i>
        <h3 style="font-size: 20px; color: #6c757d; margin-bottom: 10px;">No hay ritmos disponibles</h3>
        <p style="color: #9ca3af; margin-bottom: 30px;">Comienza creando tu primer ritmo</p>
        @can('create', App\Models\Ritmo::class)
        <a href="{{ route('ritmos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Crear Primer Ritmo
        </a>
        @endcan
    </div>
    @endforelse
</div>
@endsection
