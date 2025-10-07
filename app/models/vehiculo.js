import Model, { attr } from '@ember-data/model';

export default class VehiculoModel extends Model {
  @attr('string') marca;
  @attr('string') numeroChasis;
  @attr('string') numeroMotor;
  @attr('string') cilindrada;
  @attr('string') modelo;
  @attr('string') linea;
  @attr('string') potenciaHp;
  @attr('string') declaracionImportacion;
  @attr('string') fechaImportacion;
  @attr('string') puertas;
  @attr('string') fechaMatricula;
  @attr('string') organismoTransito;
  @attr('string') ciudad;
  @attr('string') tipoCarroceria;
  @attr('string') combustible;
  @attr('string') capacidad;
  @attr('string') propietario;
  @attr('string') identificacion;
}
