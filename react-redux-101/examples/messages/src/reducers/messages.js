const DEFAULT_STATE = { messages: [] }

const messages = function (state = DEFAULT_STATE, action) {
switch (action.type) {
    case 'ADD_MESSAGE':
        return {...state, messages: [...state.messages, action.payload.text]};
    default:
        return state;
    }
}

export default textarea;