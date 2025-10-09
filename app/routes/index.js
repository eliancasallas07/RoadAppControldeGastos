import Route from '@ember/routing/route';
import { inject as service } from '@ember/service';

export default class IndexRoute extends Route {
  @service session;
  @service router;

  beforeModel() {
    this.router.replaceWith('dashboard.iniciar-ruta');
    // Si quieres condicionar por autenticación, descomenta y ajusta:
    // if (!this.session.isAuthenticated) {
    //   this.router.replaceWith('login');
    // } else {
    //   this.router.replaceWith('dashboard.iniciar-ruta');
    // }
  }
}