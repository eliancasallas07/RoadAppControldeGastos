import Service from '@ember/service';
import { tracked } from '@glimmer/tracking';

export default class SessionService extends Service {
  @tracked token = null;
  @tracked usuario = null;

  constructor() {
    super(...arguments);
    try {
      this.token = localStorage.getItem('jwt') || null;
      const raw = localStorage.getItem('usuario');
      this.usuario = raw ? JSON.parse(raw) : null;
    } catch (e) {
      // si JSON.parse falla, limpiamos
      this.clearSession();
    }
  }

  setSession(token, usuario) {
    this.token = token || null;
    this.usuario = usuario || null;
    if (this.token) {
      localStorage.setItem('jwt', this.token);
    }
    if (this.usuario) {
      localStorage.setItem('usuario', JSON.stringify(this.usuario));
    }
  }

  clearSession() {
    this.token = null;
    this.usuario = null;
    localStorage.removeItem('jwt');
    localStorage.removeItem('usuario');
  }

  get isAuthenticated() {
    return !!this.token;
  }

  get authHeader() {
    return this.token ? `Bearer ${this.token}` : null;
  }
}
