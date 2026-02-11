@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold">{{ $ritmo->nombre }}</h1>
                        <p class="text-gray-600 mt-2">{{ $ritmo->descripcion }}</p>
                    </div>
                    <div class="flex space-x-2">
                        @can('update', $ritmo)
                            <a href="{{ route('ritmos.edit', $ritmo) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Editar
                            </a>
                        @endcan
                        @can('approve', $ritmo)
                            @if(!$ritmo->approved)
                                <form action="{{ route('ritmos.approve', $ritmo) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Aprobar
                                    </button>
                                </form>
                            @endif
                        @endcan
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    <p>BPM: {{ $ritmo->bpm_default }}</p>
                    <p>Creado por: {{ $ritmo->creador->name }}</p>
                </div>
            </div>
        </div>

        <!-- Tambores -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Tambores</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($ritmo->tambores as $tambor)
                        <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                            {{ $tambor->nombre }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Reproductor de Videos -->
        @if($ritmo->videos->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Videos</h2>
                    <div id="video-player-container" data-ritmo-id="{{ $ritmo->id }}" data-bpm="{{ $ritmo->bpm_default }}">
                        @include('ritmos.video-player', ['ritmo' => $ritmo])
                    </div>
                </div>
            </div>
        @endif

        <!-- Partituras -->
        @if($ritmo->partituras->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Partituras</h2>
                    <div class="space-y-2">
                        @foreach($ritmo->partituras as $partitura)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <span>Partitura PDF</span>
                                <a href="{{ filter_var($partitura->archivo_pdf, FILTER_VALIDATE_URL) ? $partitura->archivo_pdf : (config('filesystems.default') === 's3' ? Storage::disk('s3')->url($partitura->archivo_pdf) : Storage::url($partitura->archivo_pdf)) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                    Descargar
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @can('create', App\Models\Video::class)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Agregar Video</h2>
                    <form action="{{ route('videos.store', $ritmo) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tambor</label>
                                <select name="tambor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach($ritmo->tambores as $tambor)
                                        <option value="{{ $tambor->id }}">{{ $tambor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">URL del Video (o subir archivo)</label>
                                <input type="url" name="url_video" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Archivo de Video</label>
                                <input type="file" name="video_file" accept="video/*" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Orden de Ejecución</label>
                                <input type="number" name="orden_ejecucion" value="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Agregar Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endcan

        @can('create', App\Models\Partitura::class)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Agregar Partitura</h2>
                    <form action="{{ route('partituras.store', $ritmo) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Archivo PDF</label>
                                <input type="file" name="archivo_pdf" accept=".pdf" required class="mt-1 block w-full">
                            </div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Agregar Partitura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endcan
    </div>
</div>
@endsection

