import React from 'react';
import {BrowserRouter, Link, Route, Switch} from 'react-router-dom';
import Example from './components/Example';
import CatalogContainer from './components/Products/CatalogContainer';

const Main = props => (
    <Switch>
        <Route exact path='/app' component={Example}/>
        <Route exact path='/app/Catalog' component={CatalogContainer}/>
    </Switch>
);
export default Main;
