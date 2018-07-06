import React, { Component } from 'react';

export default class MyChildComponent extends Component {
  render() {
    return (
      <p>
        Hello { this.props.text } {/* we display the props */}
      </p>
    );
  }
}

