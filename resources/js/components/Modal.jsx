import React, {Component} from 'react'
import { IoMdSad } from "react-icons/io";

class Modal extends Component {
    render() {
        return <div className={' py-4 row justify-content-center'}>
            <div className={'col-md-6'}>
                <div className={'card'}>
                    <div className={'card-header'}>
                        {this.header}
                    </div>
                    <div className={'card-body'}>
                        <div className={'row'}>
                            {this.body1}
                        </div>
                        <div className={'row'}>
                            {this.body2}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    }
}

export class LoginModal extends Modal {
    header = 'Login to Mercado Libre to list your products';
    body1 = <div className={'col-md-6 '}>
        <a className={'btn btn-primary'} href={'/melilogin'}>
            Log in to Mercado Libre
        </a>
    </div>;
    body2 = '';

}
export class EmptyCatalog extends Modal {
    header = <div>Your catalog is empty  <IoMdSad/> </div>;
    body1 = '';
    body2 = <div className={'col-md-6 '}>
        <a className={'btn btn-primary'} href={'www.mercadolibre.com.ar/publicar'}>
            Publish something!
        </a>
    </div>;

}



