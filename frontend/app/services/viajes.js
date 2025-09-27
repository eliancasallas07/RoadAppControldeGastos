import Service from '@ember/service';
import { tracked } from '@glimmer/tracking';
import { inject as service } from '@ember/service';
import config from 'frontend/config/environment';

export default class ViajesService extends Service {
  @service session;
  @tracked list = [];

  // Fetch viajes from backend; fall back to current in-memory list on error
  async fetchViajes() {
    try {
      const headers = { 'Content-Type': 'application/json' };
      if (this.session?.token) headers['Authorization'] = `Bearer ${this.session.token}`;

  const res = await fetch(`${config.apiHost}/api/viajes`, { headers });
      if (!res.ok) throw new Error('Fetch failed');
      const data = await res.json();
      // normalize and mark expanded=false
      this.list = data.map((d) => ({ ...d, expanded: false }));
      return this.list;
    } catch (err) {
      // fallback: return in-memory list
      return this.list;
    }
  }

  // Create viaje on backend; on failure use in-memory fallback
  async createViaje({ origen, destino, vehiculo, fecha }) {
    const payload = { origen, destino, vehiculo, fecha };
    try {
      const headers = { 'Content-Type': 'application/json' };
      if (this.session?.token) headers['Authorization'] = `Bearer ${this.session.token}`;

  const res = await fetch(`${config.apiHost}/api/viajes`, {
        method: 'POST',
        headers,
        body: JSON.stringify(payload),
      });

      if (!res.ok) throw new Error('Create failed');
      const body = await res.json();

      // retrieve created viaje from server by refetching
      await this.fetchViajes();
      // find the newly created by id
      const created = this.list.find((v) => v.id === body.id) || { id: body.id, ...payload, createdAt: new Date().toISOString(), expanded: false };
      return created;
    } catch (err) {
      // fallback: create locally
      const newViaje = {
        id: Date.now(),
        origen,
        destino,
        vehiculo,
        fecha,
        createdAt: new Date().toISOString(),
        expanded: false,
      };
      this.list = [newViaje, ...this.list];
      return newViaje;
    }
  }

  toggle(id) {
    this.list = this.list.map((v) => (v.id === id ? { ...v, expanded: !v.expanded } : v));
  }
}
