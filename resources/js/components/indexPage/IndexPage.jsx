import React, {Component} from "react";
import Navbar from "../Navbar";
import {LoginModal} from "../Modal";

export default class IndexPage extends Component {
    render(){
        return <div>
        <div className={"jumbotron"}>
            <h1 className={"display-4"}>Mi Mercado</h1>
            <p className={"lead"}>Here you can list all your products and share them with your friends! </p>
            <hr className={"my-4"}/>
                <p>We ask permission to log into your account so we can list 'ALL' your products.</p>
                <p> yes, even the free ones!</p>
                <p className={"lead"}>
                    <a className={"btn btn-primary btn-lg"} href={"#"} >Learn more</a>
                </p>

        </div>
            <LoginModal/>
        </div>
    }
}
