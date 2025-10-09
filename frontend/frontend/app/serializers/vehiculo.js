import RESTSerializer from '@ember-data/serializer/rest';

export default class VehiculoSerializer extends RESTSerializer {
  primaryKey = 'id';

  normalizeArrayResponse(store, primaryModelClass, payload, id, requestType) {
    // Depuración: mostrar el payload recibido
    console.log('VehiculoSerializer payload:', payload);
    let data = Array.isArray(payload.member) ? payload.member : [];
    payload = { data };
    return super.normalizeArrayResponse(store, primaryModelClass, payload, id, requestType);
  }

  normalizeSingleResponse(store, primaryModelClass, payload, id, requestType) {
    // Forzar id desde 'id' o '@id'
    if (payload && !payload.id && payload['@id']) {
      const match = payload['@id'].match(/\/(\d+)$/);
      if (match) {
        payload.id = match[1];
      }
    }
    payload = { data: payload };
    return super.normalizeSingleResponse(store, primaryModelClass, payload, id, requestType);
  }

  serialize(snapshot, options) {
    // Devuelve los atributos en camelCase, igual que en la entidad PHP
    return { ...snapshot.attributes() };
  }

  serializeIntoHash(hash, typeClass, snapshot, options) {
    // Evita anidar bajo 'vehiculo', envía los datos planos
    Object.assign(hash, this.serialize(snapshot, options));
  }
}
