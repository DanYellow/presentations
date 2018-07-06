import React, { Component } from 'react';

export default class MyChildComponent extends Component {
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);
  }

  handleClick() {
    this.props.onClickCB()
  }

  render() {
    return (
      <p onClick={this.handleClick}>
        Hello { this.props.text } {/* we display the props */}
      </p>
    );
  }
}

