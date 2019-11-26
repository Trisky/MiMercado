import React, {Component} from 'react'
import axios from 'axios';

class Catalog extends React.Component {


    constructor(props) {
        super(props);
        this.state = {success: false};
        axios.get('/api/products')
            .then(response => response.data)
            .then(products => {
                    this.setState({products: products, success: true})
                }
            )
            .catch
            (response => {
                    this.setState({products: [], success: false})
                    console.error('failed to retieve products');
                    alert('error retrieving products')
                }
            );
    }

    render() {
        if (this.state.success) {
            let products = this.state.products;
            console.log(products);
            return (
                <div className='catalog'>
                    Here should we see the list with our products
                </div>
            )
        } else {
            return <div>loading</div>;
        }
    }
}
export default Catalog;
