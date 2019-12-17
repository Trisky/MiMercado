import Catalog from "../Products/Catalog";
import {InfoHeader} from "../Products/Header";
import React from "react";
import CatalogContainer from "../Products/CatalogContainer";

export default class AdminCatalogContainer extends CatalogContainer{
    renderCatalog(products) {
        return <div>
            <InfoHeader content={'Edit your catalog!'}/>
            <AdminCatalog products={products}/>
        </div>;
    }

}

export class AdminCatalog extends Catalog{
    componentDidMount() {
        const products = this.props.products.map(product => {
            return <AdminProduct key={product.id} data={product}/>
        });
        this.setState({products:products});
    }

}
