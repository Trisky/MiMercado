import React from 'react';
import {BrowserRouter, Link, Route, Switch} from 'react-router-dom';
import Login from './components/Login';
import CatalogContainer from './components/Products/CatalogContainer';
import Notfound from './components/Products/Notfound';

const Main = props => (
    <Switch>
        <Route exact path='/' component={Login}/>
        <Route exact path='/app/Catalog/:username' component={CatalogContainer}/>
        <Route exact path='/app/notfound' component={Notfound}/>
    </Switch>
);
export default Main;

