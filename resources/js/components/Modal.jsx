import React, {Component} from 'react'
import { IoMdSad } from "react-icons/io";

class Modal extends Component {
    render() {
        return <div className={'py-4 row justify-content-center'}>
            <div className={'col-md-6'}>
                <div className={'card'}>
                    <div className={'card-header'}>
                        {this.header}
                    </div>
                    <div className={'card-body'}>
                        {this.body}
                    </div>
                </div>
            </div>
        </div>
    }
}

const Row = props => {
    return <div className={'row'}>
        {props.body}
    </div>;
};
const ButtonShort = props => {
    return <div className={'col-md-6 '}>
        <a className={'btn btn-primary'} href={props.href}>
            {props.body}
        </a>
    </div>
};

export class LoginModal extends Modal {
    header = 'Login to Mercado Libre to list your products';
    body =
        <Row body={
            <ButtonShort body='Log in to Mercado Libre' href='/melilogin'/>
        }/>
}

export class EmptyCatalog extends Modal {
    header = <div>Your catalog is empty <IoMdSad/></div>;
    body =
        <Row body={
            <ButtonShort body='Publish something!' href='www.mercadolibre.com.ar/publicar'/>
        }/>
}



