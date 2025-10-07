import { helper } from '@ember/component/helper';

// Uso: {{eq a b}}
export default helper(function eq([a, b]) {
  return a === b;
});
