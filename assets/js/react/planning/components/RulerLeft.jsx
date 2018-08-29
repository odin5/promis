import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

class RulerLeft extends React.Component {
  render() {
    this.prop.map((turn) => (
      <span className="turn">
        <span className="turn-num">{turn.num}</span>
      </span>
    ));
    return (
      <div className="ruler-left-outer">
        <div className="ruler-left-inner">
          {/*% for i in 1..66 %*/}
          {/*% endfor %*/}
        </div>
      </div>
    )
  }
}


RulerLeft.propTypes = {
  works: PropTypes.array.isRequired,
};

const mapStateToProps = state => ({
  works: state.data.works,
});

export default connect(mapStateToProps)(RulerLeft);
