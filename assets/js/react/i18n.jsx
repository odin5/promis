import i18n from 'i18next';
import { reactI18nextModule } from 'react-i18next';
import config from '../config.js';

i18n
  .use(reactI18nextModule)
  .init({
    debug: false,
    fallbackLng: 'cs',
    keySeparator: false,

    // have a common namespace used around the full app
    ns: ['translations'],
    defaultNS: 'translations',

    resources: config.translations,

    interpolation: {
      escapeValue: false, // not needed for react!!
    },

    react: {
      wait: true
    },
  });

export default i18n;