import React, { Component } from 'react';
import MyChildComponent from './my-child-component';


class MyFirstComponent extends Component {
  constructor(props) {
    super(props);

    this.state = {  // We initialize the state
      hello: 'el mundo'
    }

    this.updateMessage = this.updateMessage.bind(this);
    setTimeout(this.updateMessage, 5000);
  }

  updateMessage() {
    // We update the state. 
    // Very important we use this.setState and not this.state.
    this.setState({ 
      hello: 'world'
    })
  }

  render() {
    return (
      <div>
        <MyChildComponent text={this.state.hello} /> {/* we pass props to the componentcd .. */}
      </div>
    );
  }
}

export default MyFirstComponent;
