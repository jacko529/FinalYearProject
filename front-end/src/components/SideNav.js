import React, { Component, Fragment } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import NavTab from './Nav/Tab';
import '../SidePanel.css';

import Logout from './auth/Logout';

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
            <div className="sidePanel">
                <div className="new">
                    <NavTab value="Hello" />
                    <NavTab value="Hello" />
                    <NavTab value="Hello" />
                    <NavTab value="Hello" />
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