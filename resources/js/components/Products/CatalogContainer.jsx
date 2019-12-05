import React, {Component} from 'react'
import axios from 'axios';
import Catalog from './Catalog';
class CatalogContainer extends Component {
    state = {
        success: false
    };
    componentDidMount() {
        const { match: { params } } = this.props;
        let username = params.username;
        axios.get(`/api/products/${username}`)
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
                <Catalog  products={products}/>
            )
        } else {
            return <div className="spinner-grow text-warning" role="status">
                <span className="sr-only">Loading...</span>
            </div>
        }
    }
}
export default CatalogContainer;
