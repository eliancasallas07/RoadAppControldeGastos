import { helper } from '@ember/component/helper';

export default helper(function jsonStringify([value]) {
  return JSON.stringify(value, null, 2);
});
