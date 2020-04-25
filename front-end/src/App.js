import React, {Component} from 'react';
import AppNavBar from './components/AppNavbar'
import {Provider} from 'react-redux';
import store from './stores/store'
import {BrowserRouter as Router} from "react-router-dom";
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';

import {loadUser} from './actions/authActions'

import ResolveRoutes from "./components/auth/ResolveRoutes"


class App extends Component {

    componentDidMount() {
        store.dispatch(loadUser());
        // store.dispatch(nextActiveLoading());

    }

    state = {
        time: false
    };


    render() {
        let links = true;
        //
        // setTimeout(function() {  this.setState({time: true}); }.bind(this), 1600);


        return (

            <Router>

                <Provider store={store}>

                    <div className={'app'}>
                        <AppNavBar/>
                        <ResolveRoutes/>
                    </div>
                </Provider>
            </Router>

        );
    }
}

export default App;


