import React from 'react';
import PropTypes from 'prop-types';
import { Provider } from 'react-redux';
import { I18nextProvider } from 'react-i18next';

import store from '../../store.jsx';
import i18n from '../../i18n.jsx';
import Screen from "./Screen.jsx";

class MainPlanning extends React.Component {

  render() {
    return (
      <Provider store={store}>
        <I18nextProvider i18n={ i18n }>
          <Screen planId={this.props.planId} />
        </I18nextProvider>
      </Provider>
    );
  }
}

MainPlanning.propTypes = {
  planId: PropTypes.number.isRequired,
};

export default MainPlanning;
