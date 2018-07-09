import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'


import FormMessage from '../components/form-message'
import ActionsCreators, { addMessage, updateTextarea } from '../actions/'


/**
* mapStateToProps
* Binds props from store (global state) to the component
* mapStateToProps takes a second parameter (ownProps) to use component's "classic" props
*/

function mapStateToProps(state, ownProps) {
  return {
    textareaValue: state.textarea,
    messages: state.messages.data
  }
}


/**
* mapDispatchToProps
* Binds actions creators to the component
* mapDispatchToProps can be a function or an object, the object syntax is a short-hand
*/

// function mapDispatchToProps(dispatch) {
//   return { actions: bindActionCreators(ActionsCreators, dispatch) }
// }

const mapDispatchToProps = {
  addMessage,
  updateTextarea,
}


/**
 * connect is an high order function and returns a new component
 * with the props binded with mapDispatchToProps and mapStateToProps
 * 
 * More about them:
 * https://medium.com/humans-create-software/a-dirt-simple-introduction-to-higher-order-functions-in-javascript-b33bf9e19056
 * https://reactjs.org/docs/higher-order-components.html
 * 
 * Note:
 * If you don't need mapStateToProps, you MUST set it as null
 */

export default connect(mapStateToProps, mapDispatchToProps)(FormMessage)
