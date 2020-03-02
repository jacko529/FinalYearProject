import React, { Component, Fragment } from 'react';
import { NavItem }  from 'react-materialize';
import { connect } from 'react-redux';
import { logout } from '../../actions/authActions';
import PropTypes from 'prop-types';

export class Logout extends Component {
  static propTypes = {
    logout: PropTypes.func.isRequired
  };

  render() {
    return (
    <div>
        <NavItem onClick={this.props.logout} >
          Logout
        </NavItem>
    </div>
    );
  }
}

export default connect(
  null,
  { logout }
)(Logout);