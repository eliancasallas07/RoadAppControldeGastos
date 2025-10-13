import Route from '@ember/routing/route';
import { inject as service } from '@ember/service';

export default class DashboardIniciarRutaRoute extends Route {
	@service viajes;

	async setupController(controller) {
		super.setupController(...arguments);
		controller.viajes = this.viajes;
		// fetch viajes from backend when entering
		await this.viajes.fetchViajes();
	}
}

