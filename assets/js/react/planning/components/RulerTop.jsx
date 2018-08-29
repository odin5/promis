import React from 'react';

export default class RulerTop extends React.Component {
  render() {

    return (
      <div className="ruler-top-outer">
        <div className="ruler-top-inner">
          {/*% for i in 1..66 %*/}
          <div className="work">
            <span className="name"></span>
            <span className="completion"></span>
            <span className="costs"></span>
          </div>
          {/*% endfor %*/}
        </div>
      </div>
    )
  }
}
