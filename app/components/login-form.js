import Component from '@glimmer/component';
import { action } from '@ember/object';
import { tracked } from '@glimmer/tracking';
import ENV from 'frontend/config/environment';
import { inject as service } from '@ember/service';

export default class LoginFormComponent extends Component {
  @service router;

  @tracked email = '';
  @tracked password = '';
  @tracked errorMessage = '';
  @service session;

  // Actualiza email
  @action
  updateEmail(event) {
    this.email = event.target.value;
  }

  // Actualiza contraseña
  @action
  updatePassword(event) {
    this.password = event.target.value;
  }

  // Maneja el submit del formulario
  @action
  async handleSubmit(event) {
    event.preventDefault();
    this.errorMessage = '';

    try {
  // Llamada al backend (usa el endpoint que genera JWT)
  let response = await fetch(`${ENV.apiHost}/api/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: this.email, password: this.password })
      });

      // Intentamos parsear JSON si viene
      let data = null;
      try {
        data = await response.json();
      } catch (e) {
        // no JSON
      }

      if (!response.ok) {
        const msg = (data && (data.error || data.message)) || `Error ${response.status}`;
        throw new Error(msg);
      }

      if (!data || !data.token) {
        throw new Error('Respuesta del servidor sin token');
      }

      // Usar servicio de sesión para guardar token y usuario
      this.session.setSession(data.token, data.usuario || null);

      // Mensaje de bienvenida (puedes quitar el alert en producción)
      if (data.usuario && data.usuario.nombre) {
        alert(`Bienvenido, ${data.usuario.nombre}!`);
      }

      // Redirigir al dashboard (logueamos para depuración)
      try {
        console.log('Intentando redirigir a dashboard...');

        // Intentamos la transición pero si no completa en 500ms forzamos la navegación
        let transitioned = false;
        try {
          await Promise.race([
            this.router.transitionTo('dashboard').then(() => (transitioned = true)),
            new Promise((res) => setTimeout(res, 500))
          ]);
        } catch (innerErr) {
          console.error('transitionTo lanzó excepción:', innerErr);
        }

        if (transitioned) {
          console.log('Redirección a dashboard completada.');
        } else {
          console.warn('Transition no completada en tiempo. Forzando navegación a /dashboard');
          try {
            window.location.href = '/dashboard';
          } catch (winErr) {
            console.error('No se pudo forzar window.location:', winErr);
            this.errorMessage = 'No se pudo redirigir al dashboard.';
          }
        }
      } catch (e) {
        console.error('Error al redirigir a dashboard:', e);
        try {
          window.location.href = '/dashboard';
        } catch (winErr) {
          console.error('No se pudo forzar window.location:', winErr);
          this.errorMessage = 'No se pudo redirigir al dashboard.';
        }
      }

    } catch (error) {
      this.errorMessage = error.message || 'Error en el login';
    }
  }
}

