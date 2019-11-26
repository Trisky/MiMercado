import React from 'react';
import {BrowserRouter, Link, Route, Switch} from 'react-router-dom';
import Example from './components/Example';
// import Login from './views/Login/Login';
// import Register from './views/Register/Register';
// import NotFound from './views/NotFound/NotFound'
// User is LoggedIn
// import PrivateRoute from './PrivateRoute'
// import Dashboard from './views/user/Dashboard/Dashboard';
const Main = props => (
    <Switch>
        {/*User might LogIn*/}
        <Route exact path='/app' component={Example}/>
        {/*User will LogIn*/}
        {/*<Route path='/login' component={Login}/>*/}
        {/*<Route path='/register' component={Register}/>*/}
        {/*/!* User is LoggedIn*!/*/}
        {/*<PrivateRoute path='/dashboard' component={Dashboard}/>*/}
        {/*/!*Page Not Found*!/*/}
        {/*<Route component={NotFound}/>*/}
    </Switch>
);
export default Main;
