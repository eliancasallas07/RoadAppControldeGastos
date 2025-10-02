

import Controller from '@ember/controller';
import { tracked } from '@glimmer/tracking';
import { action } from '@ember/object';
import { inject as service } from '@ember/service';

export default class DashboardVehiculoController extends Controller {
  constructor() {
    super(...arguments);
    this.vehiculos.fetchVehiculos();
  }
  @service vehiculos;

  @tracked marca = '';
  @tracked numeroChasis = '';
  @tracked numeroMotor = '';
  @tracked cilindrada = '';
  @tracked modelo = '';
  @tracked linea = '';
  @tracked potenciaHp = '';
  @tracked declaracionImportacion = '';
  @tracked fechaImportacion = '';
  @tracked puertas = '';
  @tracked fechaMatricula = '';
  @tracked organismoTransito = '';
  @tracked ciudad = '';
  @tracked tipoCarroceria = '';
  @tracked combustible = '';
  @tracked capacidad = '';
  @tracked propietario = '';
  @tracked identificacion = '';


  @tracked mensaje = '';


  @action
  updateVehiculoField(field, e) {
    this[field] = e.target.value;
  }

  get listaVehiculos() {
    return this.vehiculos.list;
  }

  @action
  async crearVehiculo(e) {
    e.preventDefault();
    const payload = {
      marca: this.marca,
      numeroChasis: this.numeroChasis,
      numeroMotor: this.numeroMotor,
      cilindrada: this.cilindrada,
      modelo: this.modelo,
      linea: this.linea,
      potenciaHp: this.potenciaHp,
      declaracionImportacion: this.declaracionImportacion,
      fechaImportacion: this.fechaImportacion,
      puertas: this.puertas,
      fechaMatricula: this.fechaMatricula,
      organismoTransito: this.organismoTransito,
      ciudad: this.ciudad,
      tipoCarroceria: this.tipoCarroceria,
      combustible: this.combustible,
      capacidad: this.capacidad,
      propietario: this.propietario,
      identificacion: this.identificacion
    };
    const ok = await this.vehiculos.createVehiculo(payload);
    if (ok) {
      this.mensaje = 'Vehículo creado correctamente';
      await this.vehiculos.fetchVehiculos();
    } else {
      this.mensaje = 'Error al crear vehículo';
    }
    // Limpiar campos del formulario
    this.marca = '';
    this.numeroChasis = '';
    this.numeroMotor = '';
    this.cilindrada = '';
    this.modelo = '';
    this.linea = '';
    this.potenciaHp = '';
    this.declaracionImportacion = '';
    this.fechaImportacion = '';
    this.puertas = '';
    this.fechaMatricula = '';
    this.organismoTransito = '';
    this.ciudad = '';
    this.tipoCarroceria = '';
    this.combustible = '';
    this.capacidad = '';
    this.propietario = '';
    this.identificacion = '';
  }
}
