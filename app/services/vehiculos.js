import Service from '@ember/service';
import { tracked } from '@glimmer/tracking';

export default class VehiculosService extends Service {
  @tracked list = [];

  // Simula crear un vehículo y agregarlo a la lista
  createVehiculo({ marca, modelo, placa, descripcion }) {
    const nuevo = {
      id: Date.now(),
      marca,
      modelo,
      placa,
      descripcion,
      createdAt: new Date().toISOString(),
    };
    this.list = [nuevo, ...this.list];
    return nuevo;
  }

  // Simula editar un vehículo
  editarVehiculo(id, cambios) {
    this.list = this.list.map((v) => v.id === id ? { ...v, ...cambios } : v);
  }
}
