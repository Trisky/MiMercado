import React, {Component} from 'react'
import axios from 'axios';
import Catalog from './Catalog';
import CatalogHeader from './CatalogHeader';
class CatalogContainer extends Component {

    status = {
        success: 'success',
        loading: 'loading',
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
        switch (this.state.status) {
            case this.status.success:
                let products = this.state.products;
                console.log(products);
                return (<div>
                    <CatalogHeader/>
                    <Catalog products={products}/>
                </div>);
            case this.status.loading:
                return <CatalogLoader/>;
            case this.status.error:
                return <CatalogError/>;
            default:
                console.error(this.state.status+  " is an unknown status");
        }
    }
}
export default CatalogContainer;

function CatalogLoader(){
    return <div className="spinner-grow text-warning" role="status">
        <span className="sr-only">Loading...</span>
    </div>
}

function CatalogError(){
    return <div className="alert alert-error col-md-6 col-sm-12 mx-auto text-center ">
        <strong>Failed to load the catalog:</strong>
    </div>
}

