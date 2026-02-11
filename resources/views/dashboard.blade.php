@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold mb-4">Bienvenido, {{ $user->name }}</h1>
                
                <div class="mb-4">
                    <p class="text-gray-600">Rol: 
                        <span class="font-semibold">
                            @foreach($user->getRoleNames() as $role)
                                {{ ucfirst($role) }}
                            @endforeach
                        </span>
                    </p>
                </div>

                <div class="mt-6">
                    <a href="{{ route('ritmos.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Ver Ritmos
                    </a>
                    @can('create', App\Models\Ritmo::class)
                        <a href="{{ route('ritmos.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                            Crear Ritmo
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

