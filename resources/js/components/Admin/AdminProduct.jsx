import React, {Component} from "react";
import Product, {ProductBody} from "../Products/Product";
import {IoIosEye, IoIosEyeOff, IoIosRefreshCircle} from "react-icons/io";
import axios from "axios";

export class AdminProduct extends Product {
    render() {
        return (
            <div className={this.classType}>
                <div className="card-header">
                   <VisibilityToggle product={this.props.data} visible={true}/>
                </div>
                <ProductBody data={this.props.data}/>
            </div>
        );
    }
}

class VisibilityToggle extends Component {
    productId;
    state = {
        loading: false
    };

    constructor(props) {
        super(props);
        this.productId = this.props.product.id;
        this.showAction = this.showAction.bind(this);
        this.hideAction = this.hideAction.bind(this);
    }

    componentDidMount() {
        this.setState({visible: this.props.visible, loading: this.state.loading});
    }

    render() {
        if (this.state.loading) {
            return <IoIosRefreshCircle title='changing visiblity'/>
        }
        if (this.state.visible) {
            return <IoIosEye
                onClick={this.hideAction}
                title='Click to hide this product'
            />
        } else {
            return <IoIosEyeOff
                onClick={this.showAction}
                title='Click to show this product'
            />
        }
    }

    showAction() {
        this.setState({...this.state, loading: true});
        axios.post(`/api/admin/visibility/show/${this.productId}`)
            .then(response => {
                this.setState({...this.state, visible: true, loading: false});
            }).catch(this.showError)
    }

    hideAction() {
        this.setState({...this.state, loading: true});
        axios.post(`/api/admin/visibility/hide/${this.productId}`)
            .then(response => {
                this.setState({...this.state, visible: false, loading: false});
            }).catch(this.showError)
    }

    showError() {
        this.setState({...this.state, loading: false});
        alert(`Failed to change the visibility status for the product ${this.productId}`);
    }
}
