let locales = ['cs', 'en'];
let content = require('fs').readFileSync('config/services.yaml', {encoding : 'utf8'});
let matches = content.match(/^\s*locales_array\s*:\s*\[\s*([\w\s,]+)\s*\]\s*$/m);
if(matches) {
  locales = matches[1].split(/\s*,\s*/);
}

module.exports = {
  options: {
    func: {
      list: ['i18next.t', 'i18n.t', 't'],
      extensions: ['.js', '.jsx']
    },
    lngs: locales,
    defaultLng: 'cs',
    defaultNs: 'translations',
    resource: {
      loadPath: 'react.{{lng}}.json',
      savePath: 'react.{{lng}}.json',
    },
    nsSeparator: false, // namespace separator
    keySeparator: false, // key separator
  },
};