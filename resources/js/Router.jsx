import React from 'react';
import {BrowserRouter, Link, Route, Switch} from 'react-router-dom';
import IndexPage from "./components/indexPage/IndexPage";
import CatalogContainer from './components/Products/CatalogContainer';
import Notfound from './components/Products/Notfound';
import Dashboard from "./components/Admin/Dashboard";
import AdminCatalogContainer from "./components/Admin/AdminCatalogContainer";
import Navbar from "./components/Navbar";

const Main = props => (
    <Switch>
            <Route exact path='/' render={()=><Navbar><IndexPage/></Navbar>}/>
        <Route exact path='/dashboard/:password' component={Dashboard}/>
        <Route exact path='/admin/:username' component={AdminCatalogContainer}/>
        <Route exact path='/:username' component={CatalogContainer}/>
        <Route exact path='/app/notfound' component={Notfound}/>
    </Switch>
);
export default Main;

