import { connect } from 'react-redux'

import Messages from '../components/messages'

// We create some props for our containers (aka controller / High Order Component)
function mapStateToProps(state) {
  return {
    messages: state.messages.data
  }
}

export default connect(mapStateToProps)(Messages)