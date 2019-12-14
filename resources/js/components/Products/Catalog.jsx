import React, {Component} from 'react'
import Product from './Product'
import {EmptyCatalog} from "../Modal";

class Catalog extends Component {
    render() {
        let products = this.props.products.map(product => {
            return <Product key={product.id} data={product}/>
        });
        if(products.length >0){
            return <div className="grid">
                <div className={'row justify-content-center'}> {products}</div>
            </div>
        }else{
            return <EmptyCatalog/>
        }

    }
}
export default Catalog;
