import React, { Component } from 'react';
import MyChildComponent from './my-child-component';


class MyFirstComponent extends Component {
  static defaultProps = { /* we define component's default props */
    hello: 'el mundo'
  }

  myCallback () {
    console.log('my child talks to me !');
  }

  render() {
    return (
      <div>
        <MyChildComponent text={this.props.hello} onClickCB={this.myCallback}  /> {/* we pass props to the component */}
      </div>
    );
  }
}

export default MyFirstComponent;
