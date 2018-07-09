import React from 'react'

// import { addMessage, updateTextarea } from '../actions'

export default class FormMessage extends React.Component {
    submitMessage(e) {
        e.preventDefault();
        this.props.addMessage(this.props.textareaValue);
        // this.props.dispatch(addMessage(this.props.textareaValue));
        // this.props.actions.addMessage(this.props.textareaValue);
    }

    handleChange(e) {
        this.props.updateTextarea(e.target.value);
        // this.props.dispatch(updateTextarea(e.target.value));
    }

    render() {
        const { messages } = this.props;
        return (
            <div>
                <form onSubmit={(e) => this.submitMessage(e)}>
                    <textarea
                        onChange={(e) => this.handleChange(e)}
                        value={this.props.content}
                        autoFocus="true"
                    />
                    <button>Add message</button>
                </form>
            </div>
        );
    }
}