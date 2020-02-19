import React, { Component, Fragment } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import MasterForm from './Mutliple/MasterForm';

import '../SidePanel.css';

import Logout from './auth/Logout';
import RegisterModal from "./auth/RegisterModel";

class SideNav extends Component {
    state = {
        isOpen: false
    };

    static propTypes = {
        auth: PropTypes.object.isRequired
    };

    toggle = () => {
        this.setState({
            isOpen: !this.state.isOpen
        });
    };

    render() {
        return (
            <div className="container-flex">
            <div className="mainPanel">
                {/*<MasterForm />*/}
            </div>
            </div>
        );
    }
}
const mapStateToProps = state => ({
    auth: state.auth

});

export default connect(
    mapStateToProps,
    null
)(SideNav);