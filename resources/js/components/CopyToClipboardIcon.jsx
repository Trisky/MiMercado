import React, {Component} from "react";
import {CopyToClipboard} from 'react-copy-to-clipboard';

export default class CopyToClipboardIcon extends Component {

    render() {
        let text = this.props.text;
        return (
            <CopyToClipboard text={text}
                             onCopy={() => this.setState({copied: true})}>
                <button>copy</button>
            </CopyToClipboard>)
    }
}
