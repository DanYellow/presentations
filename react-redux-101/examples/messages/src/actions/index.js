export const addMessage = function (text) {
    return {
      type: 'ADD_MESSAGE',
      payload: { text: text }
    }
}
  
export const updateTextarea = function (text) {
    return {
        type: 'UPDATE_TEXTAREA',
        payload: { text: text }
    }
}