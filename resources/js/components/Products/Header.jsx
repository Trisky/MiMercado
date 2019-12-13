import React, {Component} from "react";

class Header extends Component {

    className = "alert col-md-6 col-sm-12 mx-auto text-center ";
    classType = 'alert-info';
    spinner = '';

    render() {
        let name = this.className + this.classType;
        return (
            <div className={name}>
                {this.props.content}
                {this.spinner}
            </div>
        )
    }
}

export class LoadingHeader extends Header {
    classType = 'alert-warning';
    spinner = <CatalogSpinner/>;
}
function CatalogSpinner(){
    return (<div className="spinner-grow text-warning" role="status">
        <span className="sr-only">Loading...</span>
    </div>)
}

export class ErrorHeader extends Header {
    classType = 'alert-danger';
}

export class InfoHeader extends Header {
    classType = 'alert-info';
}



