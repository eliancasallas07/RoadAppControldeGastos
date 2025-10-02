import JSONAPIAdapter from '@ember-data/adapter/json-api';

export default class ApplicationAdapter extends JSONAPIAdapter {
  get headers() {
    return {
      'Accept': 'application/ld+json',
      'Content-Type': 'application/ld+json'
    };
  }
}