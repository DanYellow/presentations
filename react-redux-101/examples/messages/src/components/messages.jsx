import React from 'react'

import FormMessage from '../containers/form-message'

export default class Messages extends React.Component {

  render() {
    return (
      <div>
        <ul>{this.props.messages.map((message) => <li key={message}>{ message }</li>)}</ul>
        <FormMessage />
      </div>
    );
  }
}