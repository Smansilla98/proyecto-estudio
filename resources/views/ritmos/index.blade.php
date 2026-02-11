@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Ritmos</h1>
            @can('create', App\Models\Ritmo::class)
                <a href="{{ route('ritmos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Crear Ritmo
                </a>
            @endcan
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($ritmos as $ritmo)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">{{ $ritmo['nombre'] }}</h2>
                        <p class="text-gray-600 mb-4">{{ $ritmo['descripcion'] ?? 'Sin descripción' }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">BPM: {{ $ritmo['bpm_default'] }}</span>
                            @if(!$ritmo['approved'])
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Pendiente</span>
                            @endif
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('ritmos.show', $ritmo['id']) }}" class="text-indigo-600 hover:text-indigo-800">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No hay ritmos disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

