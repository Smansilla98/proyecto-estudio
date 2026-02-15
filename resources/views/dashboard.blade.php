@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Total Ritmos</div>
                        <div class="h3 mb-0 fw-bold">{{ $totalRitmos ?? 0 }}</div>
                        <div class="text-success small mt-1">
                            <i class="bi bi-arrow-up"></i> 12% desde la semana pasada
                        </div>
                    </div>
                    <div class="bg-primary bg-gradient rounded-3 p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-music-note-list text-white" style="font-size: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Total Videos</div>
                        <div class="h3 mb-0 fw-bold">{{ $totalVideos ?? 0 }}</div>
                        <div class="text-success small mt-1">
                            <i class="bi bi-arrow-up"></i> 8% desde la semana pasada
                        </div>
                    </div>
                    <div class="bg-success bg-gradient rounded-3 p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-play-circle text-white" style="font-size: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Total Partituras</div>
                        <div class="h3 mb-0 fw-bold">{{ $totalPartituras ?? 0 }}</div>
                        <div class="text-success small mt-1">
                            <i class="bi bi-arrow-up"></i> 5% desde la semana pasada
                        </div>
                    </div>
                    <div class="bg-warning bg-gradient rounded-3 p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-file-earmark-music text-white" style="font-size: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Usuarios Activos</div>
                        <div class="h3 mb-0 fw-bold">{{ $totalUsers ?? 0 }}</div>
                        <div class="text-success small mt-1">
                            <i class="bi bi-arrow-up"></i> 3% desde la semana pasada
                        </div>
                    </div>
                    <div class="bg-info bg-gradient rounded-3 p-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people text-white" style="font-size: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Card -->
<div class="card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-person-circle me-2"></i>
            Bienvenido, {{ $user->name }}
        </h2>
    </div>
    
    <div class="card-body">
        <div class="mb-3">
            <p class="text-muted mb-2">
                <strong>Rol:</strong>
                @php
                    $roles = $user->getRoleNames();
                @endphp
                @if($roles->count() > 0)
                    @foreach($roles as $role)
                        <span class="badge bg-primary ms-2">{{ ucfirst($role) }}</span>
                    @endforeach
                @else
                    <span class="badge bg-warning ms-2">Sin rol asignado</span>
                @endif
            </p>
            
            <p class="text-muted">
                Bienvenido a la plataforma de aprendizaje de la Escuela de Tambores. 
                Aquí podrás acceder a ritmos, videos y partituras para mejorar tus habilidades.
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('ritmos.index') }}" class="btn btn-primary">
                <i class="bi bi-music-note-list me-2"></i>
                Ver Ritmos
            </a>
            
            @can('create', App\Models\Ritmo::class)
            <a href="{{ route('ritmos.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>
                Crear Ritmo
            </a>
            @endcan
            
            @can('viewAny', App\Models\Video::class)
            <a href="#" class="btn btn-info">
                <i class="bi bi-play-circle me-2"></i>
                Ver Videos
            </a>
            @endcan
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title mb-0">
            <i class="bi bi-clock-history me-2"></i>
            Actividad Reciente
        </h2>
    </div>
    
    <div class="card-body">
        <p class="text-muted mb-0">No hay actividad reciente para mostrar.</p>
    </div>
</div>
@endsection
