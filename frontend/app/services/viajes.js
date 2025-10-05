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
    // Convertir fecha a formato ISO completo si viene como YYYY-MM-DD
    let fechaISO = fecha;
    if (fecha && /^\d{4}-\d{2}-\d{2}$/.test(fecha)) {
      fechaISO = `${fecha}T00:00:00`;
    }
    const payload = { origen, destino, vehiculo, fecha: fechaISO };
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
  
  // Update viaje on backend
  async updateViaje(id, fields) {
    try {
      const headers = { 'Content-Type': 'application/json' };
      if (this.session?.token) headers['Authorization'] = `Bearer ${this.session.token}`;
      const res = await fetch(`${config.apiHost}/api/viajes/${id}`, {
        method: 'PUT',
        headers,
        body: JSON.stringify(fields),
      });
      if (!res.ok) throw new Error('Update failed');
      await this.fetchViajes();
      return true;
    } catch (err) {
      return false;
    }
  }

  toggle(id) {
    this.list = this.list.map((v) => (v.id === id ? { ...v, expanded: !v.expanded } : v));
  }

  // Eliminar viaje en backend
  async deleteViaje(id) {
    try {
      const headers = { 'Content-Type': 'application/json' };
      if (this.session?.token) headers['Authorization'] = `Bearer ${this.session.token}`;
      const res = await fetch(`${config.apiHost}/api/viajes/${id}`, {
        method: 'DELETE',
        headers,
      });
      if (!res.ok) throw new Error('Delete failed');
      await this.fetchViajes();
      return true;
    } catch (err) {
      return false;
    }
  }
}
