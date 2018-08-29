import React from "react";
import ReactDOM from "react-dom";
import i18n from "./i18n.jsx";

import MainPlanning from "./planning/components/MainPlanning.jsx";
const planningScreen = document.getElementById('planning-screen');
if(planningScreen) {
  i18n.changeLanguage(planningScreen.dataset.locale);
  ReactDOM.render(<MainPlanning planId={parseInt(planningScreen.dataset.plan)} />, planningScreen);
}