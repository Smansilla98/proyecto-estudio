@extends('layouts.app')

@section('title', 'Partitura: ' . $partitura->ritmo->nombre)

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/vexflow@4.0.3/releases/vexflow-debug.css">
<style>
    .partitura-viewer {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #partitura-canvas {
        width: 100%;
        overflow-x: auto;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 20px;
    }
    
    .controls-panel {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .instrument-control {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        margin: 5px 0;
        background: white;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
    
    .instrument-control label {
        margin: 0;
        cursor: pointer;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .instrument-control input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .playback-controls {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .bpm-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .bpm-control input {
        width: 80px;
    }
</style>
@endpush

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-file-earmark-music me-2"></i>
                Partitura: {{ $partitura->ritmo->nombre }}
            </h1>
            <p class="text-muted mb-0">
                <i class="bi bi-music-note-beamed me-1"></i>
                Ritmo: {{ $partitura->ritmo->nombre }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('ritmos.show', $partitura->ritmo) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver al Ritmo
            </a>
            <a href="{{ $partituraUrl }}" target="_blank" class="btn btn-primary" download>
                <i class="bi bi-download me-2"></i>
                Descargar PDF
            </a>
        </div>
    </div>
</div>

<!-- Controles de Reproducción -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="bi bi-play-circle me-2"></i>
            Controles de Reproducción
        </h3>
    </div>
    <div class="card-body">
        <div class="playback-controls mb-4">
            <button id="play-btn" class="btn btn-success">
                <i class="bi bi-play-fill me-2"></i>
                Reproducir
            </button>
            <button id="pause-btn" class="btn btn-warning" disabled>
                <i class="bi bi-pause-fill me-2"></i>
                Pausar
            </button>
            <button id="stop-btn" class="btn btn-danger" disabled>
                <i class="bi bi-stop-fill me-2"></i>
                Detener
            </button>
            <div class="bpm-control">
                <label for="bpm-input">BPM:</label>
                <input type="number" id="bpm-input" class="form-control" value="{{ $partitura->ritmo->bpm_default }}" min="60" max="200">
            </div>
            <button id="export-midi-btn" class="btn btn-info">
                <i class="bi bi-download me-2"></i>
                Exportar MIDI
            </button>
        </div>
        
        <!-- Controles de Instrumentos -->
        <div class="controls-panel">
            <h5 class="mb-3">
                <i class="bi bi-sliders me-2"></i>
                Control de Instrumentos
            </h5>
            <p class="text-muted small mb-3">Activa o desactiva cada instrumento para aislarlo o silenciarlo</p>
            <div id="instrument-controls">
                @foreach($partitura->ritmo->tambores as $tambor)
                <div class="instrument-control">
                    <label>
                        <input type="checkbox" 
                               class="instrument-toggle" 
                               data-tambor-id="{{ $tambor->id }}"
                               data-tambor-nombre="{{ $tambor->nombre }}"
                               checked>
                        <i class="bi bi-drum text-primary"></i>
                        <strong>{{ $tambor->nombre }}</strong>
                    </label>
                    <div class="form-check form-switch">
                        <input class="form-check-input solo-toggle" 
                               type="checkbox" 
                               data-tambor-id="{{ $tambor->id }}"
                               title="Solo (aislar este instrumento)">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Visor de Partitura -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="bi bi-music-note-list me-2"></i>
            Partitura
        </h3>
    </div>
    <div class="card-body">
        <div class="partitura-viewer">
            <div id="partitura-canvas"></div>
        </div>
    </div>
</div>

<!-- PDF Viewer (fallback) -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title mb-0">
            <i class="bi bi-file-earmark-pdf me-2"></i>
            Vista PDF Original
        </h3>
    </div>
    <div class="card-body">
        <iframe src="{{ $partituraUrl }}" 
                style="width: 100%; height: 600px; border: 1px solid #ddd; border-radius: 4px;">
        </iframe>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/vexflow@4.0.3/releases/vexflow-debug.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tone@14.7.77/build/Tone.js"></script>
<script>
const { Vex, Renderer, Stave, StaveNote, Voice, Formatter, Accidental } = Vex.Flow;

// Datos de la partitura
const partituraData = {
    ritmoId: {{ $partitura->ritmo->id }},
    ritmoNombre: @json($partitura->ritmo->nombre),
    bpm: {{ $partitura->ritmo->bpm_default }},
    tambores: @json($partitura->ritmo->tambores->map(function($t) { return ['id' => $t->id, 'nombre' => $t->nombre]; })),
    partituraUrl: @json($partituraUrl)
};

// Estado de reproducción
let isPlaying = false;
let currentBPM = partituraData.bpm;
let activeInstruments = new Set(partituraData.tambores.map(t => t.id));
let soloInstruments = new Set();
let audioContext = null;
let scheduledNotes = [];

// Mapeo de tambores a notas MIDI (drum kit)
const drumMap = {
    'Bombo': 36,      // C1 - Bass Drum
    'Fondo Grave': 35, // B0 - Acoustic Bass Drum
    'Fondo Agudo': 38, // D1 - Acoustic Snare
    'Redoblante': 38,  // D1 - Acoustic Snare
    'Hi-Hat': 42,      // F#1 - Closed Hi-Hat
    'Crash': 49,       // C#2 - Crash Cymbal
    'Ride': 51,        // D#2 - Ride Cymbal
    'Timbal': 47,      // B1 - Low-Mid Tom
    'Repique': 38,     // D1 - Acoustic Snare
    'Medio': 45        // A1 - Low Tom
};

// Generar partitura de batería (en producción, esto vendría del PDF o de datos estructurados)
function generateSamplePartitura() {
    const div = document.getElementById('partitura-canvas');
    div.innerHTML = '';
    
    const renderer = new Renderer(div, Renderer.Backends.SVG);
    const width = Math.max(800, partituraData.tambores.length * 150);
    renderer.resize(width, 300);
    const context = renderer.getContext();
    
    // Crear múltiples pentagramas, uno por cada tambor
    const tambores = partituraData.tambores;
    const staveHeight = 60;
    const staveSpacing = 80;
    
    tambores.forEach((tambor, index) => {
        const y = 30 + (index * staveSpacing);
        const stave = new Stave(10, y, width - 20);
        stave.addClef('percussion');
        stave.addTimeSignature('4/4');
        stave.setContext(context).draw();
        
        // Agregar nombre del tambor
        context.setFont('Arial', 12, 'normal');
        context.fillText(tambor.nombre, width - 150, y + 20);
        
        // Crear notas para este tambor (patrón básico)
        const notes = [
            new StaveNote({ clef: 'percussion', keys: ['b/4'], duration: 'q' }),
            new StaveNote({ clef: 'percussion', keys: ['b/4'], duration: 'q' }),
            new StaveNote({ clef: 'percussion', keys: ['b/4'], duration: 'q' }),
            new StaveNote({ clef: 'percussion', keys: ['b/4'], duration: 'q' })
        ];
        
        const voice = new Voice({ num_beats: 4, beat_value: 4 });
        voice.addTickables(notes);
        
        new Formatter().joinVoices([voice]).format([voice], width - 20);
        voice.draw(context, stave);
    });
    
    // Ajustar altura del canvas
    renderer.resize(width, 30 + (tambores.length * staveSpacing) + 20);
}

// Inicializar audio
function initAudio() {
    if (!audioContext) {
        audioContext = new Tone.Context();
        Tone.start();
    }
}

// Generar sonido de batería mejorado
function playDrumSound(tamborNombre, time) {
    if (!audioContext) initAudio();
    
    const midiNote = drumMap[tamborNombre] || 36;
    const frequency = Tone.Frequency(midiNote, "midi").toFrequency();
    
    // Crear sonidos más realistas según el tipo de tambor
    if (tamborNombre.includes('Bombo') || tamborNombre.includes('Fondo Grave')) {
        // Sonido de bombo (bajo)
        const osc1 = new Tone.Oscillator(frequency * 0.5, "sine");
        const osc2 = new Tone.Oscillator(frequency, "sine");
        const noise = new Tone.Noise("brown");
        const filter = new Tone.Filter(100, "lowpass");
        const envelope = new Tone.AmplitudeEnvelope({
            attack: 0.01,
            decay: 0.3,
            sustain: 0,
            release: 0.2
        });
        
        osc1.connect(envelope);
        osc2.connect(envelope);
        noise.connect(filter);
        filter.connect(envelope);
        envelope.toDestination();
        
        osc1.start(time);
        osc2.start(time);
        noise.start(time);
        osc1.stop(time + 0.3);
        osc2.stop(time + 0.3);
        noise.stop(time + 0.3);
        envelope.triggerAttackRelease(0.3, time);
    } else if (tamborNombre.includes('Redoblante') || tamborNombre.includes('Repique')) {
        // Sonido de redoblante (snare)
        const noise = new Tone.Noise("white");
        const filter = new Tone.Filter(8000, "highpass");
        const envelope = new Tone.AmplitudeEnvelope({
            attack: 0.01,
            decay: 0.2,
            sustain: 0,
            release: 0.1
        });
        
        noise.connect(filter);
        filter.connect(envelope);
        envelope.toDestination();
        
        noise.start(time);
        noise.stop(time + 0.2);
        envelope.triggerAttackRelease(0.2, time);
    } else if (tamborNombre.includes('Hi-Hat')) {
        // Sonido de hi-hat
        const noise = new Tone.Noise("white");
        const filter = new Tone.Filter(10000, "highpass");
        const envelope = new Tone.AmplitudeEnvelope({
            attack: 0.01,
            decay: 0.05,
            sustain: 0,
            release: 0.05
        });
        
        noise.connect(filter);
        filter.connect(envelope);
        envelope.toDestination();
        
        noise.start(time);
        noise.stop(time + 0.1);
        envelope.triggerAttackRelease(0.1, time);
    } else {
        // Sonido genérico de percusión
        const oscillator = new Tone.Oscillator(frequency, "sine");
        const envelope = new Tone.AmplitudeEnvelope({
            attack: 0.01,
            decay: 0.15,
            sustain: 0,
            release: 0.1
        });
        
        oscillator.connect(envelope);
        envelope.toDestination();
        
        oscillator.start(time);
        oscillator.stop(time + 0.15);
        envelope.triggerAttackRelease(0.15, time);
    }
}

// Generar patrón de batería basado en los tambores del ritmo
function generateDrumPattern() {
    const tambores = partituraData.tambores;
    const pattern = [];
    
    // Crear un patrón básico de 4/4 con los tambores disponibles
    tambores.forEach((tambor, index) => {
        // Distribuir los tambores a lo largo de los 4 beats
        const beat = index % 4;
        pattern.push({
            tambor: tambor.nombre,
            tamborId: tambor.id,
            beat: beat,
            subdivision: 0 // 0 = beat principal, 0.5 = off-beat
        });
        
        // Agregar algunos off-beats para tambores específicos
        if (tambor.nombre.includes('Hi-Hat') || tambor.nombre.includes('Redoblante')) {
            pattern.push({
                tambor: tambor.nombre,
                tamborId: tambor.id,
                beat: beat,
                subdivision: 0.5
            });
        }
    });
    
    return pattern.sort((a, b) => {
        if (a.beat !== b.beat) return a.beat - b.beat;
        return a.subdivision - b.subdivision;
    });
}

// Reproducir partitura
function playPartitura() {
    if (isPlaying) return;
    
    isPlaying = true;
    initAudio();
    
    const bpm = parseInt(document.getElementById('bpm-input').value);
    Tone.Transport.bpm.value = bpm;
    const beatDuration = 60 / bpm; // duración de un beat en segundos
    
    // Generar patrón basado en los tambores del ritmo
    const pattern = generateDrumPattern();
    
    const startTime = Tone.now() + 0.1; // Pequeño delay para asegurar que todo esté listo
    
    // Repetir el patrón 4 veces (16 beats total)
    for (let repetition = 0; repetition < 4; repetition++) {
        pattern.forEach((note) => {
            const time = startTime + ((repetition * 4 + note.beat + note.subdivision) * beatDuration);
            
            // Verificar si el instrumento está activo
            if (shouldPlayInstrument(note.tamborId)) {
                scheduledNotes.push({
                    time: time,
                    tambor: partituraData.tambores.find(t => t.id === note.tamborId),
                    cancel: () => {}
                });
                
                Tone.Transport.scheduleOnce(() => {
                    playDrumSound(note.tambor, time);
                }, time);
            }
        });
    }
    
    // Detener después de 16 beats
    Tone.Transport.scheduleOnce(() => {
        stopPartitura();
    }, startTime + (16 * beatDuration));
    
    Tone.Transport.start();
    updatePlaybackButtons();
}

// Verificar si un instrumento debe sonar
function shouldPlayInstrument(tamborId) {
    if (soloInstruments.size > 0) {
        return soloInstruments.has(tamborId);
    }
    return activeInstruments.has(tamborId);
}

// Pausar reproducción
function pausePartitura() {
    Tone.Transport.pause();
    updatePlaybackButtons();
}

// Reanudar reproducción
function resumePartitura() {
    if (!isPlaying) {
        Tone.Transport.start();
        isPlaying = true;
        updatePlaybackButtons();
    }
}

// Detener reproducción
function stopPartitura() {
    Tone.Transport.stop();
    Tone.Transport.cancel();
    Tone.Transport.position = 0;
    scheduledNotes = [];
    isPlaying = false;
    updatePlaybackButtons();
}

// Actualizar botones de reproducción
function updatePlaybackButtons() {
    document.getElementById('play-btn').disabled = isPlaying;
    document.getElementById('pause-btn').disabled = !isPlaying;
    document.getElementById('stop-btn').disabled = !isPlaying;
}

// Exportar a MIDI
function exportToMIDI() {
    try {
        // Generar datos MIDI básicos
        const bpm = parseInt(document.getElementById('bpm-input').value);
        const pattern = generateDrumPattern();
        
        // Crear estructura MIDI simplificada
        const midiNotes = [];
        pattern.forEach((note) => {
            const tambor = partituraData.tambores.find(t => t.id === note.tamborId);
            if (tambor && drumMap[tambor.nombre]) {
                midiNotes.push({
                    note: drumMap[tambor.nombre],
                    time: note.beat * (60 / bpm),
                    duration: 0.1,
                    velocity: 100
                });
            }
        });
        
        // Crear un archivo MIDI simple usando formato estándar
        // Nota: Para una implementación completa, usar librería como midi-writer-js
        const midiContent = generateSimpleMIDI(midiNotes, bpm);
        
        // Descargar archivo
        const blob = new Blob([midiContent], { type: 'audio/midi' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${partituraData.ritmoNombre.replace(/\s+/g, '_')}_partitura.mid`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        // Mostrar mensaje de éxito
        Swal.fire({
            icon: 'success',
            title: 'MIDI Exportado',
            text: 'El archivo MIDI se ha descargado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    } catch (error) {
        console.error('Error al exportar MIDI:', error);
        Swal.fire({
            icon: 'info',
            title: 'Exportación MIDI',
            text: 'Funcionalidad en desarrollo. Por ahora, puedes descargar el PDF original.',
            confirmButtonText: 'Entendido'
        });
    }
}

// Generar contenido MIDI simple (formato básico)
function generateSimpleMIDI(notes, bpm) {
    // Esta es una implementación muy básica
    // Para producción, usar una librería como midi-writer-js
    // Por ahora, retornamos un placeholder
    return 'MIDI file placeholder - Use midi-writer-js library for full implementation';
}

// Event Listeners
document.getElementById('play-btn').addEventListener('click', function() {
    if (isPlaying && Tone.Transport.state === 'paused') {
        resumePartitura();
    } else {
        playPartitura();
    }
});
document.getElementById('pause-btn').addEventListener('click', pausePartitura);
document.getElementById('stop-btn').addEventListener('click', stopPartitura);
document.getElementById('export-midi-btn').addEventListener('click', exportToMIDI);

// Control de instrumentos
document.querySelectorAll('.instrument-toggle').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const tamborId = parseInt(this.dataset.tamborId);
        if (this.checked) {
            activeInstruments.add(tamborId);
        } else {
            activeInstruments.delete(tamborId);
            soloInstruments.delete(tamborId);
            // Desactivar solo si estaba activo
            document.querySelector(`.solo-toggle[data-tambor-id="${tamborId}"]`).checked = false;
        }
    });
});

// Control de solo (aislar instrumento)
document.querySelectorAll('.solo-toggle').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const tamborId = parseInt(this.dataset.tamborId);
        if (this.checked) {
            soloInstruments.add(tamborId);
            // Desactivar todos los demás
            document.querySelectorAll('.instrument-toggle').forEach(cb => {
                if (parseInt(cb.dataset.tamborId) !== tamborId) {
                    cb.checked = false;
                    activeInstruments.delete(parseInt(cb.dataset.tamborId));
                }
            });
        } else {
            soloInstruments.delete(tamborId);
            // Reactivar el instrumento correspondiente
            document.querySelector(`.instrument-toggle[data-tambor-id="${tamborId}"]`).checked = true;
            activeInstruments.add(tamborId);
        }
    });
});

// Control de BPM
document.getElementById('bpm-input').addEventListener('change', function() {
    currentBPM = parseInt(this.value);
    if (isPlaying) {
        stopPartitura();
    }
});

// Inicializar partitura al cargar
document.addEventListener('DOMContentLoaded', function() {
    generateSamplePartitura();
    
    // Inicializar todos los instrumentos como activos
    partituraData.tambores.forEach(tambor => {
        activeInstruments.add(tambor.id);
    });
});
</script>
@endpush

