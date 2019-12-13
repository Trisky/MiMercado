import React, {Component} from "react";

export default class Dashboard extends Component {

    render() {
        let href = window.location.href;
        return <div className="alert alert-info col-md-6 col-sm-12 mx-auto text-center ">
            <strong>Welcome!</strong> {href}
        </div>
    }
}
