import React from 'react';
import {Redirect, Route} from 'react-router-dom';
import {connect} from 'react-redux';


const TeacherPrivateRoute = ({component: Component, auth, ...rest}) =>
    (
        <Route {...rest} render={(props) => (
            auth.isAuthenticated && auth.isTeacher
                ? <Component {...props} />
                : <Redirect to={{
                    pathname: '/',
                    state: {from: props.location}
                }}/>
        )}/>

    );


const mapStateToProps = state => ({
    auth: state.auth
});

export default connect(
    mapStateToProps,
    null
)(TeacherPrivateRoute);