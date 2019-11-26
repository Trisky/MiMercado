import React from 'react';
import {BrowserRouter, Link, Route, Switch} from 'react-router-dom';
import Example from './components/Example';
import Catalog from './components/Products/Catalog';

const Main = props => (
    <Switch>
        <Route exact path='/app' component={Example}/>
        <Route exact path='/app/Catalog' component={Catalog}/>
    </Switch>
);
export default Main;
