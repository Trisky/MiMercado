import React, {Component} from "react";

class CatalogHeader extends Component {

    render() {
        let href = window.location.href;
        return <div className="alert alert-info col-md-6 col-sm-12 mx-auto text-center ">
            <strong>Share it!</strong> {href}
        </div>
    }
}
export default CatalogHeader;
