import Service from '@ember/service';
import { tracked } from '@glimmer/tracking';
import { inject as service } from '@ember/service';

let nextId = 1;

export default class NotificationsService extends Service {
  @service viajes;
  @tracked list = [];
  // sonido habilitado por defecto (tracked para reactividad en templates)
  @tracked soundEnabled = true;
  // ruta por defecto para un archivo en public/ (pon tu MP3 en frontend/public/sounds/notify.mp3)
  audioUrl = '/sounds/notify.mp3';

  constructor() {
    super(...arguments);
    // seed sample reminders (one-time) but avoid playing sound during seed
    this._suppressSoundDuringSeed = true;
    this.seedSamples();
    this._suppressSoundDuringSeed = false;
    // exponer en window para pruebas rápidas desde la consola
    if (typeof window !== 'undefined') {
      // eslint-disable-next-line no-undef
      window.__notificationsService = this;
    }
    // optional: keep polling for new (demo) notifications
    this._poll = setInterval(() => this.generateDemoNotification(), 60000);
    // track previous unread count to detect increases
    this._prevUnread = this.unreadCount;
  }

  willDestroy() {
    super.willDestroy(...arguments);
    clearInterval(this._poll);
  }

  get unreadCount() {
    return this.list.filter((n) => !n.read).length;
  }

  add(message, meta = {}) {
    const n = {
      id: nextId++,
      message,
      createdAt: new Date().toISOString(),
      read: false,
      ...meta,
    };
    this.list = [n, ...this.list];
    // reproducir sonido si está habilitado y si el número de no leídos aumenta
    try {
      const currentUnread = this.unreadCount;
      if (!this._suppressSoundDuringSeed && currentUnread > (this._prevUnread || 0)) {
        this.playSound();
      }
      this._prevUnread = currentUnread;
    } catch (e) {
      // eslint-disable-next-line no-console
      console.warn('notifications: playSound check error', e);
    }
    return n;
  }

  enableSound(enable = true) {
    this.soundEnabled = !!enable;
  }

  playSound() {
    if (!this.soundEnabled) return;
    // Primero intenta reproducir un archivo si existe audioUrl
    try {
      if (this.audioUrl && typeof Audio !== 'undefined') {
        const a = new Audio(this.audioUrl);
        // ignorar promesas rechazadas (autoplay/policy)
        a.play().catch(() => {
          // fallback a WebAudio si el archivo no puede reproducirse
          this._playBeepFallback();
        });
        return;
      }
    } catch (e) {
      // seguir a fallback
    }

    // Fallback: generar beep con Web Audio API
    this._playBeepFallback();
  }

  _playBeepFallback() {
    try {
      if (typeof window !== 'undefined' && (window.AudioContext || window.webkitAudioContext)) {
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        const ctx = new AudioCtx();
        const o = ctx.createOscillator();
        const g = ctx.createGain();
        o.type = 'sine';
        o.frequency.value = 880;
        g.gain.setValueAtTime(0.0001, ctx.currentTime);
        g.gain.exponentialRampToValueAtTime(0.5, ctx.currentTime + 0.01);
        o.connect(g);
        g.connect(ctx.destination);
        o.start();
        g.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.18);
        o.stop(ctx.currentTime + 0.19);
        setTimeout(() => { try { ctx.close && ctx.close(); } catch (e) {} }, 400);
      }
    } catch (e) {
      // swallow audio errors
    }
  }

  remove(id) {
    this.list = this.list.filter((n) => n.id !== id);
  }

  markRead(id) {
    this.list = this.list.map((n) => (n.id === id ? { ...n, read: true } : n));
  }

  markAllRead() {
    this.list = this.list.map((n) => ({ ...n, read: true }));
  }

  clear() {
    this.list = [];
  }

  seedSamples() {
    // create a few example reminders for the user to see
    // Use viajes data if available to make messages slightly realistic
    this.add('🔔 Tienes un viaje sin finalizar desde hace 3 días.');
    this.add('💸 Saldo pendiente por cobrar del viaje #125.');
    this.add('🛠️ Revisión técnico-mecánica del vehículo vence en 10 días.');
  }

  generateDemoNotification() {
    // Keep demo notifications light — add a small informational message occasionally
    const samples = [
      'Recordatorio: revisa tus viajes pendientes.',
      'Nuevo mensaje del cliente relacionado con el viaje #127.',
      'Consejo: actualiza la documentación del vehículo.',
    ];
    const msg = samples[Math.floor(Math.random() * samples.length)];
    this.add(msg);
  }
}
