import React from 'react';

export default class RulerCorner extends React.Component {
  render() {
    return (
      <div className="ruler-corner">
        <span className="top-ruler-label">Týdny</span>
        <hr className="divider" />
        <span className="left-ruler-label">Práce</span>
      </div>
    )
  }
}

