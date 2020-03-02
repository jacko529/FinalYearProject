import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import './App.css';
import store from "./stores/store";
import {loadUser} from "./actions/authActions";

store.dispatch(loadUser());

ReactDOM.render(<App />, document.getElementById('root'));


