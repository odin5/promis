import React from 'react';
import GridCell from "./GridCell.jsx";

export default class GridRow extends React.Component {
  render() {
    return (
      <div className="grid-row">
        <GridCell/>
      </div>
    )
  }
}
