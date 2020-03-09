import React, { Component } from 'react';
import {
    NavItem,
    Navbar,
    Icon
} from 'react-materialize';

import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import RegisterModal from './auth/RegisterModel';
import LoginModal from './auth/LoginModel';
import '../Loader.css';
import '../SidePanel.css';

import Logout from './auth/Logout';

class AppNavbar extends Component {
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
      const { isLoading, isAuthenticated, user } = this.props.auth;



    let navOutput = 0;
    if(!isLoading && isAuthenticated ){
      navOutput = 1;
    }else if(!isLoading && !isAuthenticated){
      navOutput = 2;
    }


    return (

        <div>

            <Navbar
                className={'navy'}
                alignLinks="right"
                brand={<a href='/me'>Easy Learn</a>}
                menuIcon={<Icon>menu</Icon>}
                options={{
                    draggable: true,
                    edge: 'left',
                    inDuration: 250,
                    onCloseEnd: null,
                    onCloseStart: null,
                    onOpenEnd: null,
                    onOpenStart: null,
                    outDuration: 200,
                    preventScrolling: true
                }}
                sidenav={<li>Custom node!</li>}
            >
                <NavItem href="">
                    {(navOutput === 1) ?  <strong style={{color: 'darkgray'}}>{user ? `Welcome ${user.first_name}` : ''}</strong>
                        : (navOutput === 2 ) ?  <LoginModal /> : ""}
                </NavItem>
                <NavItem >
                    {(navOutput === 1) ?  <Logout /> : (navOutput === 2 ) ?   <RegisterModal /> : ""}
                </NavItem>
            </Navbar>
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
)(AppNavbar);