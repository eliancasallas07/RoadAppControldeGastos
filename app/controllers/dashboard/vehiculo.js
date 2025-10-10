
import Controller from '@ember/controller';

export default class DashboardVehiculoController extends Controller {
  marca = '';
  modelo = '';
  placa = '';
  descripcion = '';
  chasis = '';
  motor = '';
  cilindrada = '';
  linea = '';
  potencia = '';
  declaracionImportacion = '';
  fechaImportacion = '';
  puertas = '';
  fechaMatricula = '';
  organismoTransito = '';
  ciudad = '';
  carroceria = '';
  combustible = '';
  capacidad = '';
  propietario = '';
  identificacion = '';

  updateVehiculoField(field, event) {
    this[field] = event.target.value;
  }
}
