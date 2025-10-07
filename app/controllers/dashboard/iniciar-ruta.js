import Controller from '@ember/controller';
import { inject as service } from '@ember/service';
import { action } from '@ember/object';

import { tracked } from '@glimmer/tracking';

export default class DashboardIniciarRutaController extends Controller {
  @service viajes;

  @tracked editingViaje = null;
  @tracked editFields = {};

  @tracked nuevoViaje = {
    origen: '', destino: '', vehiculo: '', fecha: '',
    valorFlete: '', comision: '', cargueValor: '', descargueValor: '',
    descarrozar: '', peajes: '', acpm: '', parqueos: '',
    lavados: '', reparaciones: '', descuentos: '', pesoKilos: '', tipoCarga: '', documentos: null
  };

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
  guardarEdicion(e) {
    if (e) e.preventDefault();
    // DEMO: solo actualiza en frontend para que no falle sin backend
    let idx = this.viajes.list.findIndex(v => v.id === this.editingViaje);
    if (idx !== -1) {
      this.viajes.list[idx] = { ...this.viajes.list[idx], ...this.editFields };
      alert('Cambios guardados (demo)');
    } else {
      alert('No se encontró el viaje para editar');
    }
    this.editingViaje = null;
    this.editFields = {};
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
  async eliminarViaje(viaje) {
    if (confirm('¿Seguro que deseas eliminar este viaje?')) {
      const ok = await this.viajes.deleteViaje(viaje.id);
      if (ok) {
        alert('Viaje eliminado');
      } else {
        alert('Error al eliminar el viaje');
      }
    }
  }

  @action
  updateNuevoViajeField(field, event) {
    this.nuevoViaje = { ...this.nuevoViaje, [field]: event.target.value };
  }

  @action
  updateNuevoViajeFile(field, event) {
    this.nuevoViaje = { ...this.nuevoViaje, [field]: event.target.files };
  }

  @action
  async crearNuevoViaje(event) {
    event.preventDefault();
    // Solo se envían los campos básicos al backend, el resto quedan en frontend
    const { origen, destino, vehiculo, fecha } = this.nuevoViaje;
    await this.viajes.createViaje({ origen, destino, vehiculo, fecha });
    this.nuevoViaje = {
      origen: '', destino: '', vehiculo: '', fecha: '',
      valorFlete: '', comision: '', cargueValor: '', descargueValor: '',
      descarrozar: '', peajes: '', acpm: '', parqueos: '',
      lavados: '', reparaciones: '', descuentos: '', pesoKilos: '', tipoCarga: '', documentos: null
    };
  }
}
