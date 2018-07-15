// making webpack put assets into folder public/build
const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);
require('../css/app.scss');

//window.$ = window.jQuery = require('jquery');
require('./lib/materialize.js');

require('./base.js');

import React from "react";
import ReactDOM from "react-dom";

import Layout from "./reactWidgets/components/Layout";

const app = document.getElementById('app');
//ReactDOM.render(<Layout/>, app);