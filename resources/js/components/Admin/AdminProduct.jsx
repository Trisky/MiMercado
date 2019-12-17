import React, {Component} from "react";
import Product, {ProductBody} from "../Products/Product";
import {IoIosEye, IoIosEyeOff, IoIosRefreshCircle} from "react-icons/io";

export class AdminProduct extends Product {
    render() {
        return (
            <div className={this.classType}>
                <div className="card-header">
                    Edit visiblity: <VisibilityToggle product={this.props.data} visible={true}/>
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
        console.error('TODO show action', this.productId);
        this.setState({...this.state, visible: true});
    }

    hideAction() {
        console.error('TODO hide action', this.productId);
        this.setState({...this.state, visible: false});
    }
}
