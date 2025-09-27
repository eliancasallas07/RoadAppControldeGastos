import Controller from '@ember/controller';
import { inject as service } from '@ember/service';
import { action } from '@ember/object';

export default class DashboardIniciarRutaController extends Controller {
  @service viajes;

  @action
  toggleViaje(viajeId) {
    this.viajes.toggle(viajeId);
  }
}
