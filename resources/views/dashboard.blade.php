@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Stats Cards -->
    <div class="card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12px; color: #6c757d; text-transform: uppercase; margin-bottom: 5px;">Total Ritmos</div>
                <div style="font-size: 28px; font-weight: 700; color: #1e293b;">{{ $ritmosCount ?? 0 }}</div>
                <div style="font-size: 12px; color: #10b981; margin-top: 5px;">
                    <i class="fas fa-arrow-up"></i> 12% desde la semana pasada
                </div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-music" style="font-size: 28px; color: #fff;"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12px; color: #6c757d; text-transform: uppercase; margin-bottom: 5px;">Total Videos</div>
                <div style="font-size: 28px; font-weight: 700; color: #1e293b;">{{ $videosCount ?? 0 }}</div>
                <div style="font-size: 12px; color: #10b981; margin-top: 5px;">
                    <i class="fas fa-arrow-up"></i> 8% desde la semana pasada
                </div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-video" style="font-size: 28px; color: #fff;"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12px; color: #6c757d; text-transform: uppercase; margin-bottom: 5px;">Total Partituras</div>
                <div style="font-size: 28px; font-weight: 700; color: #1e293b;">{{ $partiturasCount ?? 0 }}</div>
                <div style="font-size: 12px; color: #10b981; margin-top: 5px;">
                    <i class="fas fa-arrow-up"></i> 5% desde la semana pasada
                </div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-file-alt" style="font-size: 28px; color: #fff;"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12px; color: #6c757d; text-transform: uppercase; margin-bottom: 5px;">Usuarios Activos</div>
                <div style="font-size: 28px; font-weight: 700; color: #1e293b;">{{ $usersCount ?? 0 }}</div>
                <div style="font-size: 12px; color: #10b981; margin-top: 5px;">
                    <i class="fas fa-arrow-up"></i> 3% desde la semana pasada
                </div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-users" style="font-size: 28px; color: #fff;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Card -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-user-circle" style="margin-right: 10px; color: #6366f1;"></i>
            Bienvenido, {{ $user->name }}
        </h2>
    </div>
    
    <div style="margin-bottom: 20px;">
        <p style="color: #6c757d; margin-bottom: 15px;">
            <strong>Rol:</strong>
            @php
                $roles = $user->getRoleNames();
            @endphp
            @if($roles->count() > 0)
                @foreach($roles as $role)
                    <span class="badge badge-success" style="margin-left: 8px;">{{ ucfirst($role) }}</span>
                @endforeach
            @else
                <span class="badge badge-warning" style="margin-left: 8px;">Sin rol asignado</span>
            @endif
        </p>
        
        <p style="color: #6c757d; margin-bottom: 20px;">
            Bienvenido a la plataforma de aprendizaje de la Escuela de Tambores. 
            Aquí podrás acceder a ritmos, videos y partituras para mejorar tus habilidades.
        </p>
    </div>

    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="{{ route('ritmos.index') }}" class="btn btn-primary">
            <i class="fas fa-music"></i>
            Ver Ritmos
        </a>
        
        @can('create', App\Models\Ritmo::class)
        <a href="{{ route('ritmos.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i>
            Crear Ritmo
        </a>
        @endcan
        
        @can('viewAny', App\Models\Video::class)
        <a href="#" class="btn" style="background: #3b82f6; color: #fff;">
            <i class="fas fa-video"></i>
            Ver Videos
        </a>
        @endcan
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-clock" style="margin-right: 10px; color: #6366f1;"></i>
            Actividad Reciente
        </h2>
    </div>
    
    <div style="color: #6c757d;">
        <p>No hay actividad reciente para mostrar.</p>
    </div>
</div>
@endsection
