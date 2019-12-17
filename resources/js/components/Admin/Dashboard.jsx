import React, {Component} from "react";
import axios from "axios";

export default class Dashboard extends Component {

    componentDidMount() {
        axios.get(`/api/admin/dashboard/${password}`)
            .then(response => response.data)
            .then(response => {
                    this.setState({products: response.accounts, status: response.status})
                }
            )
            .catch
            (response => {
                    this.setState({products: [], status:'error' });
                    console.error('error retrieving accounts');
                    alert('error retrieving accounts')
                }
            );
    }

    render() {
        let href = window.location.href;
        return <div className="alert alert-info col-md-6 col-sm-12 mx-auto text-center ">
            <strong>Welcome!</strong> {href}
        </div>
    }
}
