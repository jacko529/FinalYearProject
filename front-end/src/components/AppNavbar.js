import React, { Component, Fragment } from 'react';
import {
  Collapse,
  Navbar,
  NavbarToggler,
  NavbarBrand,
  Nav,
  NavItem,
  NavLink,
  Container
} from 'reactstrap';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import RegisterModal from './auth/RegisterModel';
import LoginModal from './auth/LoginModel';
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

    const authLinks = (
      <Fragment>
        <NavItem>
          <span className='navbar-text mr-3'>
            <strong>{user ? `Welcome ${user.first_name}` : ''}</strong>
          </span>
        </NavItem>
        <NavItem>
          <Logout />
        </NavItem>
      </Fragment>
    );

    const guestLinks = (
      <Fragment>
        <NavItem>
          <RegisterModal />
        </NavItem>
        <NavItem>
          <LoginModal />
        </NavItem>
      </Fragment>
    );

    const loadingSign = (
        <div>
          <h1>Loading...</h1>
        </div>
    );


    let navOutput = 0;
    if(!isLoading && isAuthenticated ){
      navOutput = 1;
    }else if(!isLoading && !isAuthenticated){
      navOutput = 2;
    }

    return (
      <div>
        <Navbar color='dark' dark expand='sm' className='mb-5'>
          <Container>
            <NavbarBrand href='/'>Easy Learning</NavbarBrand>
            <NavbarToggler onClick={this.toggle} />
            <Collapse isOpen={this.state.isOpen} navbar>
              <Nav className='ml-auto' navbar>
                {(navOutput === 1) ? authLinks : (navOutput === 2 ) ? guestLinks : ""}
              </Nav>
            </Collapse>
          </Container>
        </Navbar>
        {isLoading ? loadingSign: ''}
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