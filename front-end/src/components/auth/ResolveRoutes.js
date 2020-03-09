import React, { Component } from 'react';
import { connect } from 'react-redux';
import PrivateRoute from "./PrivateRoute";
import Entry from "../Home/Entry";
import CourseContent from "../Home/CourseContent";
import TeacherRoute from "./TeacherPrivateRoute";
import TeachHome from "../TeachUpload/TeachHome";
import UploadCourse from "../TeachUpload/UploadCourse";
import UploadContent from "../TeachUpload/UploadContent";
import MasterForm from "../Mutliple/MasterForm";
import {NonUser} from "../Home/NonUser";

import {
    Switch,
    Route

} from "react-router-dom";
import Loader from "react-loader-spinner";


export class ResolveRoutes extends Component {




    render() {

        const {isLoading} = this.props.auth;
        // const {nextActiveLoaded } = this.props.next;

        const loadingSign = (
            <div className={!isLoading ? 'normal' : 'loader  '} style={{textAlign:'center'}}>
                <Loader
                    type="MutatingDots"
                    color="#00BFFF"
                    height={80}
                    width={80}
                    timeout={500} //3 secs
                />
            </div>
        );




        return (
            <div>
                {isLoading ? loadingSign :
                    <Switch>
                        <PrivateRoute path='/me' component={Entry}/>
                        <PrivateRoute path='/content' component={CourseContent}/>
                        <PrivateRoute path='/admin' component={CourseContent}/>
                        <TeacherRoute path='/home' component={TeachHome}/>
                        <TeacherRoute path='/upload-course' component={UploadCourse}/>
                        <TeacherRoute path='/upload-content' component={UploadContent}/>
                        <Route path="/quiz" component={MasterForm}/>
                        <Route path="/" component={NonUser}/>
                        <Route path="/norm"/>
                    </Switch>

                }
            </div>
        )

    }
}




const mapStateToProps = state => ({
    auth: state.auth,
    // next: state.nextActiveLoaded,

});

export default connect(
    mapStateToProps,
    null
)(ResolveRoutes);