import React, { Component } from 'react';

export default class MyChildComponent extends Component {
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);
  }

  handleClick() {
    this.props.onClickCB() // We call the props function from the parent
  }

  render() {
    return (
      <p onClick={this.handleClick}> {/* we bind an event on <p> */}
        Hello { this.props.text }
      </p>
    );
  }
}
