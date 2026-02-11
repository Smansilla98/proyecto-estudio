// Metrónomo standalone (si se necesita usar independientemente)
class Metronome {
    constructor(bpm = 120) {
        this.bpm = bpm;
        this.isRunning = false;
        this.audioContext = null;
        this.intervalId = null;
    }

    start() {
        if (this.isRunning) return;

        try {
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            console.error('Web Audio API no soportada');
            return;
        }

        this.isRunning = true;
        const interval = 60000 / this.bpm;

        this.intervalId = setInterval(() => {
            this.playClick();
        }, interval);
    }

    stop() {
        this.isRunning = false;
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
    }

    setBPM(bpm) {
        this.bpm = bpm;
        if (this.isRunning) {
            this.stop();
            this.start();
        }
    }

    playClick() {
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
}

// Exportar para uso global si es necesario
window.Metronome = Metronome;

