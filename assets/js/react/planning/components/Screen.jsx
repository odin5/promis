import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { translate, Trans } from 'react-i18next';

import RulerCorner from "./RulerCorner.jsx";
import RulerTop from "./RulerTop.jsx";
import RulerLeft from "./RulerLeft.jsx";
import Grid from "./Grid.jsx";
import SettingsBar from "./SettingsBar.jsx";

import { savePlanId, fetchPlanning } from '../actions.jsx';

class Screen extends React.Component {
  componentDidMount() {
    this.props.savePlanId(this.props.planId);
    if(!this.props.data.lastUpdate) {
      this.props.fetchPlanning(this.props.planId);
    }
  }

  render() {
    let screenContent = <div />;

    if(this.props.data && this.props.data.lastUpdate) {
      screenContent = (
        <div>
          <SettingsBar/>
          <div className="the-screen">
            <div className="corner-and-top-ruler-wrap">
              <RulerCorner />
              <RulerTop />
            </div>
            <div className="left-ruler-and-viewport-wrap">
              <RulerLeft />
              <Grid />
            </div>
          </div>
        </div>
      );
    }

    return screenContent;
  }
}

Screen.propTypes = {
  planId: PropTypes.number.isRequired,
  savePlanId: PropTypes.func.isRequired,
  fetchPlanning: PropTypes.func.isRequired,
  data: PropTypes.object,
};

const mapStateToProps = state => ({
  statePlanId: state.planning.planId,
  data: state.planning.data,
});

const actionMakers = {
  savePlanId,
  fetchPlanning
};

export default connect(mapStateToProps, actionMakers) (translate()(Screen));
