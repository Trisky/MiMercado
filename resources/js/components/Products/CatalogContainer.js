import React, {Component} from 'react'
import axios from 'axios';
import Catalog from './Catalog';
class CatalogContainer extends React.Component {
    state = {
        success: false
    };
    componentDidMount() {
        axios.get('/api/products')
            .then(response => response.data)
            .then(products => {
                    this.setState({products: products, success: true})
                }
            )
            .catch
            (response => {
                    this.setState({products: [], success: false});
                    console.error('error retrieving products');
                    alert('error retrieving products')
                }
            );
    }

    render() {
        if (this.state && this.state.success) {
            let products = this.state.products;
            console.log(products);
            return (
                <Catalog products={products}/>
            )
        } else {
            return <div className="spinner-grow text-warning" role="status">
                <span className="sr-only">Loading...</span>
            </div>
        }
    }
}
export default CatalogContainer;
