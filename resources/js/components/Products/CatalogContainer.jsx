import React, {Component} from 'react'
import axios from 'axios';
import Catalog from './Catalog';
import {LoadingHeader,ErrorHeader,InfoHeader}  from './Header';
import CopyToClipboardIcon from "../CopyToClipboardIcon";

class CatalogContainer extends Component {
    url = "/api/products"

    status = {
        success: 'success',
        loading: 'loading',
        waiting: 'waiting',//wait for the products to be available
        error: 'error',
        notAvailable: 'notavailable',
    };

    state = {
        status: this.status.loading
    };
    loadProducts() {
        const { match: { params } } = this.props;
        let username = params.username;

         axios.get(`${this.url}/${username}`)
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
    componentDidMount() {
        this.loadProducts();
    }

    render() {
        console.log(this.state.status);
        switch (this.state.status) {
            case this.status.success:
                let products = this.state.products;
                console.log({products});
                return this.renderCatalog(products);
            case this.status.loading:
                return <LoadingHeader content={'Loading'}/>;
            case this.status.notAvailable:
                return <ErrorHeader content={<strong>Catalog not available for this user</strong>}/>;
            case this.status.error:
                return <ErrorHeader content={<strong>Failed to load the catalog</strong>}/>;
            case this.status.waiting:
                this.queueReload();
                return <LoadingHeader content={'The catalog is being retrieved from Mercado Libre, please wait'}/>;
            default:
                console.error(this.state.status + " is an unknown status");
        }
    }

    renderCatalog(products) {
        return <div>
            <InfoHeader content={<HeaderContent/>}/>
            <Catalog products={products}/>
        </div>;
    }

    queueReload() {
        setTimeout(() => this.loadProducts(), 2000);
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
