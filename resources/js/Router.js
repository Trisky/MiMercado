import React from 'react';
import {BrowserRouter, Link, Route, Switch} from 'react-router-dom';
import Login from './components/Login';
import CatalogContainer from './components/Products/CatalogContainer';

const Main = props => (
    <Switch>
        <Route exact path='/' component={Login}/>
        <Route exact path='/app/Catalog/:username' component={CatalogContainer}/>
    </Switch>
);
export default Main;

