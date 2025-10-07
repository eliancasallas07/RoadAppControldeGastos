import Controller from '@ember/controller';
import { tracked } from '@glimmer/tracking';
import { action } from '@ember/object';

export default class DashboardGananciasController extends Controller {
  @tracked valorFlete = 0;
  @tracked comision = 0;
  @tracked cargue = 0;
  @tracked descargue = 0;
  @tracked descarrozar = 0;
  @tracked peajes = 0;
  @tracked acpm = 0;
  @tracked parqueos = 0;
  @tracked lavados = 0;
  @tracked reparaciones = 0;
  @tracked descuentos = 0;

  get gananciaFinal() {
    return (
      Number(this.valorFlete) -
      Number(this.comision) -
      Number(this.cargue) -
      Number(this.descargue) -
      Number(this.descarrozar) -
      Number(this.peajes) -
      Number(this.acpm) -
      Number(this.parqueos) -
      Number(this.lavados) -
      Number(this.reparaciones) -
      Number(this.descuentos)
    );
  }

  @action
  updateGananciaField(field, e) {
    this[field] = e.target.value;
  }
}
