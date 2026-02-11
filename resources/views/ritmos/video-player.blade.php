<div class="video-player-wrapper">
    <!-- Metrónomo -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-semibold mb-4">Metrónomo</h3>
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">BPM</label>
                <input type="range" id="bpm-slider" min="60" max="200" value="{{ $ritmo->bpm_default }}" class="w-full">
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>60</span>
                    <span id="bpm-value">{{ $ritmo->bpm_default }}</span>
                    <span>200</span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button id="metronome-toggle" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    ▶️ Tocar con Metrónomo
                </button>
                <div id="metronome-visualizer" class="w-4 h-4 rounded-full bg-gray-300"></div>
            </div>
        </div>
    </div>

    <!-- Controles Globales -->
    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
        <div class="flex items-center space-x-4">
            <button id="play-all" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                ▶️ Reproducir Todos
            </button>
            <button id="pause-all" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                ⏸️ Pausar Todos
            </button>
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Velocidad:</label>
                <select id="speed-selector" class="rounded-md border-gray-300 shadow-sm">
                    <option value="0.5">0.5x</option>
                    <option value="1" selected>1x</option>
                    <option value="1.25">1.25x</option>
                    <option value="1.5">1.5x</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Videos por Tambor -->
    <div class="space-y-4">
        @foreach($ritmo->videos as $video)
            <div class="video-item border rounded-lg p-4" data-video-id="{{ $video->id }}" data-tambor-id="{{ $video->tambor_id }}">
                <div class="flex items-start justify-between mb-2">
                    <h4 class="font-semibold">{{ $video->tambor->nombre }}</h4>
                    <div class="flex items-center space-x-2">
                        <button class="play-individual bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                            ▶️
                        </button>
                        <button class="pause-individual bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-1 px-3 rounded">
                            ⏸️
                        </button>
                    </div>
                </div>
                <video 
                    class="w-full rounded" 
                    controls 
                    src="{{ filter_var($video->url_video, FILTER_VALIDATE_URL) ? $video->url_video : (config('filesystems.default') === 's3' ? Storage::disk('s3')->url($video->url_video) : Storage::url($video->url_video)) }}"
                    preload="metadata"
                >
                    Tu navegador no soporta el elemento video.
                </video>
                <div class="mt-2 flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <label class="text-sm text-gray-700">Volumen:</label>
                        <input type="range" class="volume-slider" min="0" max="100" value="100" class="w-24">
                        <span class="volume-value text-sm text-gray-600">100%</span>
                    </div>
                    <button class="mute-toggle bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-bold py-1 px-3 rounded">
                        🔊
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

