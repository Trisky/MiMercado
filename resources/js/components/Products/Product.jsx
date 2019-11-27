import React, {Component} from 'react'

class Product extends Component {
    render() {
        let data = this.props.data;

        return (
            <div className="card col-md-3 col-sm-10 m-2" >
                <img className="card-img-top" src={data.pictures[0]} alt="Card image cap"/>
                <div className="card-body">
                    <h5 className="card-title">{data.title}</h5>
                    <p className="card-text font-weight-bold">${data.price}</p>
                    <a href={data.permalink} className="btn btn-primary" target="_blank">Ver en Mercado Libre</a>
                </div>
            </div>
        )
    }
}
export default Product
