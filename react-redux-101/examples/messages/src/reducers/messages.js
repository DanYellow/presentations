const DEFAULT_STATE = { data: [] }

const messages = function (state = DEFAULT_STATE, action) {
switch (action.type) {
    case 'ADD_MESSAGE':
        console.log('v', action.payload)
        return {...state, data: [...state.data, action.payload.text]};
    default:
        return state;
    }
}

export default messages;