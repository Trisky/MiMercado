import React, {Component} from 'react'

class Product extends Component {
    render() {
        let data = this.props.data;

        return (
            <div className="grid-item card p-3 m-3" style={{width: '18rem'}}>
                <img className="card-img-top" src={data.pictures[0]} alt="Card image cap"/>
                <div className="card-body">
                    <h5 className="card-title">{data.title}</h5>
                    <p className="card-text font-weight-bold">${data.price}</p>
                    <a href={data.permaLink} className="btn btn-primary">Ver en Mercado Libre</a>
                </div>
            </div>
        )
    }
}
export default Product
