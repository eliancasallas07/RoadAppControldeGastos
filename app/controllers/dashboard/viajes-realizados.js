import Controller from '@ember/controller';
import { inject as service } from '@ember/service';

export default class DashboardViajesRealizadosController extends Controller {
  @service viajes;

  // Acciones para los botones (puedes implementar la lógica real después)
  verViaje(viaje) {
    alert(`Ver viaje: ${JSON.stringify(viaje)}`);
  }
  editarViaje(viaje) {
    alert(`Editar viaje: ${JSON.stringify(viaje)}`);
  }
  finalizarViaje(viaje) {
    alert(`Finalizar viaje: ${JSON.stringify(viaje)}`);
  }
  eliminarViaje(viaje) {
    alert(`Eliminar viaje: ${JSON.stringify(viaje)}`);
  }
}
