import React, {Component} from 'react';
import {connect} from 'react-redux';
import PropTypes from 'prop-types';

import '../SidePanel.css';

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