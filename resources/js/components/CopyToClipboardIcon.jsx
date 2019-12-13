import React, {Component} from "react";
import {CopyToClipboard} from 'react-copy-to-clipboard';
import { IoIosCopy } from "react-icons/io";

export default class CopyToClipboardIcon extends Component {
    render() {
        let text = this.props.text;
        return (
            <CopyToClipboard text={text}
                             title='copy to clipboard'
                             onCopy={() => this.setState({copied: true})}
            >
                <IoIosCopy/>
            </CopyToClipboard>)
    }
}
