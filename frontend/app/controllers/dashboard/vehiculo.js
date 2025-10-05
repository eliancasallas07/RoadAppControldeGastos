import Controller from '@ember/controller';
import { inject as service } from '@ember/service';
import { tracked } from '@glimmer/tracking';
import { action } from '@ember/object';

export default class DashboardVehiculoController extends Controller {
  @service vehiculos;

  @tracked marca = '';
  @tracked modelo = '';
  @tracked placa = '';
  @tracked descripcion = '';
  @tracked chasis = '';
  @tracked motor = '';
  @tracked cilindrada = '';
  @tracked linea = '';
  @tracked potencia = '';
  @tracked declaracionImportacion = '';
  @tracked fechaImportacion = '';
  @tracked puertas = '';
  @tracked fechaMatricula = '';
  @tracked organismoTransito = '';
  @tracked ciudad = '';
  @tracked carroceria = '';
  @tracked combustible = '';
  @tracked capacidad = '';
  @tracked propietario = '';
  @tracked identificacion = '';

  @tracked editandoId = null;
  @tracked editMarca = '';
  @tracked editModelo = '';
  @tracked editPlaca = '';
  @tracked editDescripcion = '';

  @action
  updateVehiculoField(field, event) {
    this[field] = event.target.value;
  }

  @action
  crearVehiculo(e) {
    if (e) e.preventDefault();
    this.vehiculos.createVehiculo({
      marca: this.marca,
      modelo: this.modelo,
      placa: this.placa,
      descripcion: this.descripcion,
      chasis: this.chasis,
      motor: this.motor,
      cilindrada: this.cilindrada,
      linea: this.linea,
      potencia: this.potencia,
      declaracionImportacion: this.declaracionImportacion,
      fechaImportacion: this.fechaImportacion,
      puertas: this.puertas,
      fechaMatricula: this.fechaMatricula,
      organismoTransito: this.organismoTransito,
      ciudad: this.ciudad,
      carroceria: this.carroceria,
      combustible: this.combustible,
      capacidad: this.capacidad,
      propietario: this.propietario,
      identificacion: this.identificacion
    });
    // Limpiar todos los campos
    this.marca = this.modelo = this.placa = this.descripcion = '';
    this.chasis = this.motor = this.cilindrada = this.linea = this.potencia = '';
    this.declaracionImportacion = this.fechaImportacion = this.puertas = '';
    this.fechaMatricula = this.organismoTransito = this.ciudad = '';
    this.carroceria = this.combustible = this.capacidad = '';
    this.propietario = this.identificacion = '';
  }

  @action
  verVehiculo(vehiculo) {
    alert(`Vehículo: ${vehiculo.marca} ${vehiculo.modelo} (${vehiculo.placa})\n${vehiculo.descripcion}`);
  }

  @action
  editarVehiculo(vehiculo) {
    this.editandoId = vehiculo.id;
    this.editMarca = vehiculo.marca;
    this.editModelo = vehiculo.modelo;
    this.editPlaca = vehiculo.placa;
    this.editDescripcion = vehiculo.descripcion;
  }

  @action
  guardarEdicion(id) {
    this.vehiculos.editarVehiculo(id, {
      marca: this.editMarca,
      modelo: this.editModelo,
      placa: this.editPlaca,
      descripcion: this.editDescripcion
    });
    this.editandoId = null;
  }

  @action
  cancelarEdicion() {
    this.editandoId = null;
  }
}
