import Component from '@glimmer/component';
import { action } from '@ember/object';

export default class ViajeActionButtonsComponent extends Component {
  @action
  onVer() {
    if (typeof this.args.onVer === 'function') {
      this.args.onVer();
    }
  }

  @action
  onEditar() {
    if (typeof this.args.onEditar === 'function') {
      this.args.onEditar();
    }
  }

  @action
  onFinalizar() {
    if (typeof this.args.onFinalizar === 'function') {
      this.args.onFinalizar();
    }
  }

  @action
  onEliminar() {
    if (typeof this.args.onEliminar === 'function') {
      this.args.onEliminar();
    }
  }
}
