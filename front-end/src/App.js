import React, { Component} from 'react';
import AppNavBar from './components/AppNavbar'
import { Provider } from 'react-redux';
import store from './stores/store'
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import {loadUser} from './actions/authActions'


class App extends Component {
  componentDidMount() {
    store.dispatch(loadUser());
  }
  render() {
    return (
    <Provider store={store}>
    <div className="App">
        <AppNavBar/>
    </div>
    </Provider>
  );
  }
}

export default App;


