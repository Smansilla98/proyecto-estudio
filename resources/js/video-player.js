class VideoPlayerController {
    constructor() {
        this.videos = [];
        this.isPlaying = false;
        this.speed = 1.0;
        this.metronomeActive = false;
        this.metronomeBPM = 120;
        this.metronomeInterval = null;
        this.audioContext = null;
        this.init();
    }

    init() {
        const container = document.getElementById('video-player-container');
        if (!container) return;

        this.metronomeBPM = parseInt(container.dataset.bpm) || 120;
        this.loadVideos();
        this.setupEventListeners();
        this.initMetronome();
    }

    loadVideos() {
        const videoElements = document.querySelectorAll('.video-item video');
        videoElements.forEach((videoEl, index) => {
            const videoItem = videoEl.closest('.video-item');
            const video = {
                element: videoEl,
                id: videoItem.dataset.videoId,
                tamborId: videoItem.dataset.tamborId,
                volume: 1.0,
                muted: false,
            };
            this.videos.push(video);
        });
    }

    setupEventListeners() {
        // Controles globales
        const playAllBtn = document.getElementById('play-all');
        const pauseAllBtn = document.getElementById('pause-all');
        const speedSelector = document.getElementById('speed-selector');

        if (playAllBtn) {
            playAllBtn.addEventListener('click', () => this.playAll());
        }

        if (pauseAllBtn) {
            pauseAllBtn.addEventListener('click', () => this.pauseAll());
        }

        if (speedSelector) {
            speedSelector.addEventListener('change', (e) => {
                this.setSpeed(parseFloat(e.target.value));
            });
        }

        // Controles individuales
        this.videos.forEach((video, index) => {
            const videoItem = video.element.closest('.video-item');
            const playBtn = videoItem.querySelector('.play-individual');
            const pauseBtn = videoItem.querySelector('.pause-individual');
            const volumeSlider = videoItem.querySelector('.volume-slider');
            const volumeValue = videoItem.querySelector('.volume-value');
            const muteBtn = videoItem.querySelector('.mute-toggle');

            if (playBtn) {
                playBtn.addEventListener('click', () => this.playVideo(index));
            }

            if (pauseBtn) {
                pauseBtn.addEventListener('click', () => this.pauseVideo(index));
            }

            if (volumeSlider) {
                volumeSlider.addEventListener('input', (e) => {
                    const volume = parseFloat(e.target.value) / 100;
                    this.setVolume(index, volume);
                    if (volumeValue) {
                        volumeValue.textContent = `${Math.round(volume * 100)}%`;
                    }
                });
            }

            if (muteBtn) {
                muteBtn.addEventListener('click', () => this.toggleMute(index, muteBtn));
            }
        });
    }

    playAll() {
        this.isPlaying = true;
        this.videos.forEach((video) => {
            video.element.playbackRate = this.speed;
            video.element.play().catch(console.error);
        });
    }

    pauseAll() {
        this.isPlaying = false;
        this.videos.forEach((video) => {
            video.element.pause();
        });
    }

    playVideo(index) {
        const video = this.videos[index];
        video.element.playbackRate = this.speed;
        video.element.play().catch(console.error);
    }

    pauseVideo(index) {
        this.videos[index].element.pause();
    }

    setSpeed(speed) {
        this.speed = speed;
        this.videos.forEach((video) => {
            video.element.playbackRate = speed;
        });
    }

    setVolume(index, volume) {
        const video = this.videos[index];
        video.volume = volume;
        video.element.volume = volume;
    }

    toggleMute(index, muteBtn) {
        const video = this.videos[index];
        video.muted = !video.muted;
        video.element.muted = video.muted;
        muteBtn.textContent = video.muted ? '🔇' : '🔊';
    }

    initMetronome() {
        const toggleBtn = document.getElementById('metronome-toggle');
        const bpmSlider = document.getElementById('bpm-slider');
        const bpmValue = document.getElementById('bpm-value');
        const visualizer = document.getElementById('metronome-visualizer');

        if (bpmSlider && bpmValue) {
            bpmSlider.value = this.metronomeBPM;
            bpmValue.textContent = this.metronomeBPM;

            bpmSlider.addEventListener('input', (e) => {
                this.metronomeBPM = parseInt(e.target.value);
                bpmValue.textContent = this.metronomeBPM;
                if (this.metronomeActive) {
                    this.stopMetronome();
                    this.startMetronome();
                }
            });
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (this.metronomeActive) {
                    this.stopMetronome();
                    toggleBtn.textContent = '▶️ Tocar con Metrónomo';
                } else {
                    this.startMetronome();
                    toggleBtn.textContent = '⏸️ Detener Metrónomo';
                    this.playAll();
                }
            });
        }
    }

    startMetronome() {
        this.metronomeActive = true;
        const interval = 60000 / this.metronomeBPM; // ms por beat

        try {
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            console.error('Web Audio API no soportada');
            return;
        }

        let beatCount = 0;
        this.metronomeInterval = setInterval(() => {
            this.playMetronomeClick();
            this.visualizeBeat();
            beatCount++;
        }, interval);
    }

    stopMetronome() {
        this.metronomeActive = false;
        if (this.metronomeInterval) {
            clearInterval(this.metronomeInterval);
            this.metronomeInterval = null;
        }
    }

    playMetronomeClick() {
        if (!this.audioContext) return;

        const oscillator = this.audioContext.createOscillator();
        const gainNode = this.audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(this.audioContext.destination);

        oscillator.frequency.value = 800;
        oscillator.type = 'sine';

        gainNode.gain.setValueAtTime(0.3, this.audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.1);

        oscillator.start(this.audioContext.currentTime);
        oscillator.stop(this.audioContext.currentTime + 0.1);
    }

    visualizeBeat() {
        const visualizer = document.getElementById('metronome-visualizer');
        if (visualizer) {
            visualizer.classList.add('bg-indigo-500');
            setTimeout(() => {
                visualizer.classList.remove('bg-indigo-500');
                visualizer.classList.add('bg-gray-300');
            }, 100);
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('video-player-container')) {
        new VideoPlayerController();
    }
});

