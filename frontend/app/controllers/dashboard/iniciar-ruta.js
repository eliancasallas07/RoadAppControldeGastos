import Controller from '@ember/controller';
import { inject as service } from '@ember/service';
import { action } from '@ember/object';

import { tracked } from '@glimmer/tracking';

export default class DashboardIniciarRutaController extends Controller {
  @service viajes;

  @tracked editingViaje = null;
  @tracked editFields = {};

  @action
  toggleViaje(viajeId) {
    this.viajes.toggle(viajeId);
  }

  @action
  editarViaje(viaje) {
    this.editingViaje = viaje.id;
    this.editFields = { ...viaje };
  }

  @action
  cancelarEdicion() {
    this.editingViaje = null;
    this.editFields = {};
  }

  @action
  guardarEdicion() {
    // Actualiza el viaje en el backend
    this.viajes.updateViaje(this.editingViaje, this.editFields).then((ok) => {
      if (!ok) {
        alert('Error al guardar los cambios');
      }
      this.editingViaje = null;
      this.editFields = {};
    });
  }

  @action
  updateField(field, event) {
    this.editFields = { ...this.editFields, [field]: event.target.value };
  }

  @action
  finalizarViaje(viaje) {
    alert(`Finalizar viaje ID: ${viaje.id}`);
  }

  @action
  eliminarViaje(viaje) {
    if (confirm('¿Seguro que deseas eliminar este viaje?')) {
      this.viajes.list = this.viajes.list.filter((v) => v.id !== viaje.id);
      alert('Viaje eliminado');
    }
  }
}
