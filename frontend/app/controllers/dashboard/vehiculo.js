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
  @tracked editVehiculo = {};
  @tracked mensaje = '';

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
    this.mensaje = 'Vehículo creado correctamente';
    setTimeout(() => { this.mensaje = ''; }, 2000);
  }

  @action
  editarVehiculo(vehiculo) {
    this.editandoId = vehiculo.id;
    // Precargar todos los campos existentes (aunque solo uno tenga valor)
    this.editVehiculo = {
      marca: vehiculo.marca || '',
      modelo: vehiculo.modelo || '',
      placa: vehiculo.placa || '',
      descripcion: vehiculo.descripcion || '',
      chasis: vehiculo.chasis || '',
      motor: vehiculo.motor || '',
      cilindrada: vehiculo.cilindrada || '',
      linea: vehiculo.linea || '',
      potencia: vehiculo.potencia || '',
      declaracionImportacion: vehiculo.declaracionImportacion || '',
      fechaImportacion: vehiculo.fechaImportacion || '',
      puertas: vehiculo.puertas || '',
      fechaMatricula: vehiculo.fechaMatricula || '',
      organismoTransito: vehiculo.organismoTransito || '',
      ciudad: vehiculo.ciudad || '',
      carroceria: vehiculo.carroceria || '',
      combustible: vehiculo.combustible || '',
      capacidad: vehiculo.capacidad || '',
      propietario: vehiculo.propietario || '',
      identificacion: vehiculo.identificacion || ''
    };
  }

  @action
  updateEditVehiculoField(field, event) {
    this.editVehiculo = { ...this.editVehiculo, [field]: event.target.value };
  }

  @action
  guardarEdicion(id, e) {
    if (e) e.preventDefault();
    this.vehiculos.editarVehiculo(id, { ...this.editVehiculo });
    this.editandoId = null;
    this.editVehiculo = {};
    this.mensaje = 'Vehículo modificado con éxito';
    setTimeout(() => { this.mensaje = ''; }, 2000);
  }

  @action
  cancelarEdicion() {
    this.editandoId = null;
    this.editVehiculo = {};
  }

  @action
  verVehiculo(vehiculo) {
    let desc = `Marca: ${vehiculo.marca || ''}\nModelo: ${vehiculo.modelo || ''}\nPlaca: ${vehiculo.placa || ''}`;
    desc += `\nChasis: ${vehiculo.chasis || ''}\nMotor: ${vehiculo.motor || ''}`;
    desc += `\nPropietario: ${vehiculo.propietario || ''}`;
    alert(desc);
  }
}
