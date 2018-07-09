const DEFAULT_STATE = ''

const textarea = function (state = DEFAULT_STATE, action) {
    switch (action.type) {
      case 'UPDATE_TEXTAREA':
        return action.payload.text;
      default:
        return state;
    }
  }

export default textarea;
