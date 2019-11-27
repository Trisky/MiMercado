import React, {Component} from 'react'
import Product from './Product'

class Catalog extends Component {
    render() {
        let products = this.props.products.map(product => {
            return <Product key={product.id} data={product}/>
        });
        return <div className="grid">
            <div className={'row justify-content-center'}> {products}</div>
        </div>
    }
}
export default Catalog;
