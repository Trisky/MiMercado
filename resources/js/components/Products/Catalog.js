import React, {Component} from 'react'
import axios from 'axios';
class Catalog extends Component{
    componentDidMount(){
        axios.get('/api/products')
            .then(response => response.data)
            .then(products =>this.setState({products}));
    }

    render(){
        console.log(this.state);
        return (
            <div className='catalog'>
                Here should we see the list with our products
            </div>
        )
    }
}
export default Catalog;
