import { combineReducers } from 'redux'

import messages from './messages'
import textarea from './textarea'

const reducers = combineReducers({
  messages,
  textarea
});

export default reducers