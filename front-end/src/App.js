import React, {Component} from 'react';
import AppNavBar from './components/AppNavbar'
import {Provider} from 'react-redux';
import store from './stores/store'
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
} from "react-router-dom";
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import {loadUser} from './actions/authActions'
import Entry from "./components/Home/Entry";
import CourseContent from "./components/Home/CourseContent";
import TeachHome from "./components/TeachUpload/TeachHome";
import UploadContent from "./components/TeachUpload/UploadContent";
import UploadCourse from "./components/TeachUpload/UploadCourse";
import MasterForm from "./components/Mutliple/MasterForm";
import PrivateRoute from "./components/auth/PrivateRoute";
import {NonUser} from "./components/Home/NonUser";
import { createBrowserHistory } from "history";


class App extends Component {
    componentDidMount() {
        store.dispatch(loadUser());
    }


    render() {

        return (
            <Router>
                <Provider store={store}>
                    <div className="App" style={{backgroundColor: '#0582CA'}}>
                        <AppNavBar/>
                        <Switch>
                            <PrivateRoute path='/me' component={Entry}/>
                            <PrivateRoute path='/content' component={CourseContent}/>
                            <PrivateRoute path='/admin' component={CourseContent}/>
                            <PrivateRoute path='/home' component={TeachHome}/>
                            <PrivateRoute path='/upload-course' component={UploadCourse}/>
                            <PrivateRoute path='/upload-content' component={UploadContent}/>
                            <Route path="/quiz" component={MasterForm}/>
                            <Route path="/" component={NonUser}/>
                            <Route path="/norm"/>
                        </Switch>
                    </div>
                </Provider>
            </Router>

        );
    }
}

export default App;


