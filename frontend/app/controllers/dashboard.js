import Controller from '@ember/controller';
import { action } from '@ember/object';
import { tracked } from '@glimmer/tracking';
import { inject as service } from '@ember/service';

export default class DashboardController extends Controller {
  @service router;
  @service viajes;

  @tracked origen = '';
  @tracked destino = '';
  @tracked vehiculo = '';
  @tracked fecha = '';

  @action
  navigate(routeName) {
    if (routeName) {
      this.router.transitionTo(routeName);
    }
  }

  @action
  updateOrigen(e) {
    this.origen = e.target.value;
  }

  @action
  updateDestino(e) {
    this.destino = e.target.value;
  }

  @action
  updateVehiculo(e) {
    this.vehiculo = e.target.value;
  }

  @action
  updateFecha(e) {
    this.fecha = e.target.value;
  }

  @action
  async createViaje() {
    if (!this.origen || !this.destino || !this.vehiculo || !this.fecha) {
      // basic validation
      alert('Por favor completa todos los campos');
      return;
    }

    // call backend (with fallback inside service)
    const created = await this.viajes.createViaje({
      origen: this.origen,
      destino: this.destino,
      vehiculo: this.vehiculo,
      fecha: this.fecha,
    });

    // clear form
    this.origen = '';
    this.destino = '';
    this.vehiculo = '';
    this.fecha = '';

    // navigate to iniciar-ruta and expand the created viaje
    this.router.transitionTo('dashboard.iniciar-ruta').then(() => {
      this.viajes.toggle(created.id);
    });
  }
}
