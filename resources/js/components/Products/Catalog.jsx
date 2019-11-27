import React, {Component} from 'react'
import Product from './Product'

class Catalog extends Component {
    render() {
        let products = this.props.products.map(product => {
            return <Product key={product.id} data={product} className="grid-item"/>
        });
        return  <div className="container-fluid">
                    <div className="grid">{products}</div>
                </div>
    }
}
export default Catalog;
