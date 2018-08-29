// making webpack put assets into folder public/build
const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);
require('../css/main.scss');

import config from './config.js';
const translationContext = require.context('../../translations', true, /^react\.(\w+)\.json$/);
translationContext.keys().forEach(key => {
  const locale = key.match(/^react\.(\w+)\.json$/)[1];
  config['translations'][locale] = translationContext(key);
});

import 'whatwg-fetch';
window.$ = window.jQuery = require('jquery');
require('./lib/materialize.js');
require('./lib/bootstrap.js');

require('./base.js');

require('./react/index.jsx');

