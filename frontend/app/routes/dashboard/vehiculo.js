import Route from '@ember/routing/route';
import { inject as service } from '@ember/service';

export default class DashboardVehiculoRoute extends Route {
	@service store;

	async model() {
		return this.store.findAll('vehiculo', { reload: true });
	}

	setupController(controller, model) {
		super.setupController(controller, model);
		controller.model = model;
	}
}
