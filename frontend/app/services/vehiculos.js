import Service from '@ember/service';
import { tracked } from '@glimmer/tracking';
import config from 'frontend/config/environment';

export default class VehiculosService extends Service {
  @tracked list = [];

  async fetchVehiculos() {
    try {
      const res = await fetch(`${config.apiHost}/api/vehiculos`, {
        headers: { 'Accept': 'application/ld+json' }
      });
      if (!res.ok) throw new Error('Fetch failed');
      const data = await res.json();
      this.list = Array.isArray(data.member) ? data.member : [];
      return this.list;
    } catch (err) {
      return this.list;
    }
  }

  async createVehiculo(payload) {
    try {
      const res = await fetch(`${config.apiHost}/api/vehiculos`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/ld+json',
          'Accept': 'application/ld+json'
        },
        body: JSON.stringify(payload),
      });
      if (!res.ok) throw new Error('Create failed');
      await this.fetchVehiculos();
      return true;
    } catch (err) {
      return false;
    }
  }
}
