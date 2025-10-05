
import Route from '@ember/routing/route';
import { inject as service } from '@ember/service';

export default class IndexRoute extends Route {
  @service session;
  @service router;

  beforeModel() {
    // if (!this.session.isAuthenticated) {
    //   this.router.replaceWith('login');
    // }
    // Saltando login temporalmente para pruebas
  }

// Cambio menor para forzar build en Netlify
}
