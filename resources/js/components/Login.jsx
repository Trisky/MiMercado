import React, {Component} from 'react'

class Login extends Component {
    render() {
        return <div className={' py-4 row justify-content-center'}>
            <div className={'col-md-6'}>
                <div className={'card'}>
                    <div className={'card-header'}>
                        Login to Mercado Libre to list your products
                    </div>
                    <div className={'card-body'}>
                        <div className={'row'}>
                            <div className={'col-md-6'}>
                                <a className={'btn btn-primary'} href={'/melilogin'}> Log in to Mercado Libre
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    }
}
export default Login
