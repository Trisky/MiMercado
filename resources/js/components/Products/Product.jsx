import React, {Component} from 'react'



export default class Product extends Component {
    classType = 'card col-md-3 col-sm-10 m-2';
    render() {
        return (
            <div className={this.classType} >
                <ProductBody data={this.props.data}/>
            </div>
        )
    }
}

export class ProductBody extends Component {
    render() {
        const data = this.props.data;
        return (
            <div>
                <img className="card-img-top" src={data.pictures[0]} alt="Card image cap"/>
                <div className="card-body">
                    <h5 className="card-title">{data.title}</h5>
                    <p className="card-text font-weight-bold">${data.price}</p>
                    <a href={data.permalink} className="btn btn-primary" target="_blank">Ver en Mercado Libre</a>
                </div>
            </div>
        );
    }
}
