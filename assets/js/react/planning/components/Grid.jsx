import React from 'react';
import GridRow from "./GridRow.jsx";

export default class Grid extends React.Component {
  render() {
    return (
      <div className="planning-viewport">
        <div className="planning-grid">
          <GridRow/>
        </div>
      </div>
    )
  }
}