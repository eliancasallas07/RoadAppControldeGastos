import JSONAPIAdapter from '@ember-data/adapter/json-api';

export default class VehiculoAdapter extends JSONAPIAdapter {
  host = 'http://localhost:8000'; // Cambia el puerto si tu backend usa otro
  namespace = 'api';

  // Forzar la ruta correcta para el modelo vehiculo
  pathForType() {
    return 'vehiculos';
  }

  get headers() {
    return {
      'Accept': 'application/ld+json',
      'Content-Type': 'application/ld+json'
    };
  }
}
