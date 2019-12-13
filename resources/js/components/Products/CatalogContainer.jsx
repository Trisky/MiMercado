import React, {Component} from 'react'
import axios from 'axios';
import Catalog from './Catalog';
import {LoadingHeader,ErrorHeader,InfoHeader}  from './Header';
import CopyToClipboardIcon from "../CopyToClipboardIcon";
class CatalogContainer extends Component {

    status = {
        success: 'success',
        loading: 'loading',
        waiting: 'waiting',//wait for the products to be available
        error: 'error'
    };

    state = {
        status: this.status.loading
    };
    componentDidMount() {
        const { match: { params } } = this.props;
        let username = params.username;
        axios.get(`/api/products/${username}`)
            .then(response => response.data)
            .then(response => {
                    this.setState({products: response.products, status: response.status})
                }
            )
            .catch
            (response => {
                    this.setState({products: [], status:this.status.error });
                    console.error('error retrieving products');
                    alert('error retrieving products')
                }
            );
    }

    render() {
        console.log(this.state.status);
        switch (this.state.status) {
            case this.status.success:
                let products = this.state.products;
                console.log({products});
                return <div>
                    <InfoHeader content={<HeaderContent/>}/>
                    <Catalog products={products}/>
                </div>;
            case this.status.loading:
                return <LoadingHeader content={'Loading'}/>;
            case this.status.error:
                return <ErrorHeader content={<strong>Failed to load the catalog</strong>}/>;
            case this.status.waiting:
                return <LoadingHeader content={'The catalog is being retrieved from Mercado Libre, please wait'}/>;
            default:
                console.error(this.state.status + " is an unknown status");
        }
    }
}
export default CatalogContainer;

function HeaderContent(){
    const href = window.location.href;
    return <div>
        <strong>Share it!</strong> {href}
        <CopyToClipboardIcon text={href}/>
    </div>;
}
