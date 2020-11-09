import React, {Component} from "react";

export default class Navbar extends Component {
    constructor(props) {
        super(props);
    }
    render() {
        console.log(this);
        return <div>
            <nav className="navbar navbar-expand-lg navbar-light bg-light">
                <a className="navbar-brand" href="#">Mi Mercado</a>
                <button className="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item active">
                            <a className="nav-link" href="#">Home <span className="sr-only">(current)</span></a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="#">See other catalogs</a>
                        </li>


                    </ul>
                    <form className="form-inline my-2 my-lg-0">
                        <button className="btn btn-outline-warning my-2 my-sm-0" type="submit">Log in to list your products!</button>
                    </form>

                </div>
            </nav>
            {this.props.children}
        </div>
    }
}
