import React, { Component } from 'react';
// import {
//   Button,
//   Modal,
//   ModalHeader,
//   ModalBody,
//   Form,
//   FormGroup,
//   Label,
//   Input,
//   NavLink,
//   Alert
// } from 'reactstrap';
import {

  Nav,
  NavItem,
  Button,
  TextInput,
  Modal,
  Model
} from 'react-materialize';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { login } from '../../actions/authActions';
import { clearErrors } from '../../actions/errorActions';
import { Redirect } from 'react-router-dom';

class LoginModal extends Component {
  state = {
    modal: false,
    username: '',
    password: '',
    msg: null,
    redirect: false
  };

  static propTypes = {
    isAuthenticated: PropTypes.bool,
    error: PropTypes.object.isRequired,
    login: PropTypes.func.isRequired,
    clearErrors: PropTypes.func.isRequired
  };

  componentDidUpdate(prevProps) {
    const { error, isAuthenticated } = this.props;
    if (error !== prevProps.error) {
      // Check for register error
      if (error.id === 'LOGIN_FAIL') {
        this.setState({ msg: error.msg.msg });
      } else {
        this.setState({ msg: null });
      }
    }

    // If authenticated, close modal
    if (this.state.modal) {
      if (isAuthenticated) {

        this.toggle();

      }
    }
  }

  toggle = () => {
    // Clear errors
    this.props.clearErrors();
    this.setState({
      modal: !this.state.modal
    });
  };

  onChange = e => {
    this.setState({ [e.target.name]: e.target.value });
  };

  onSubmit = e => {
    console.log('clock')
    e.preventDefault();

    const { username, password } = this.state;

    const user = {
      username,
      password
    };

    // Attempt to login
    this.props.login(user);
  };

  render() {

    return (

        <Modal
            actions={[
              <Button flat modal="close" node="button" waves="green">Close</Button>
            ]}
            bottomSheet={false}
            fixedFooter={false}
            header="Login"
            id="modal-0"
            style={{    width: '50%', height: 'auto'}}
            options={{
              dismissible: true,
              endingTop: '10%',
              inDuration: 250,
              onCloseEnd: null,
              onCloseStart: null,
              onOpenEnd: null,
              onOpenStart: null,
              opacity: 0.6,
              outDuration: 250,
              preventScrolling: true,
              startingTop: '4%'
            }}
            trigger={<Button node="button">Login</Button>}
        >
          <TextInput
              label="First Name"
              value={this.state.username}
              onChange={this.onChange}
              name={'username'}
          />

          <TextInput
              label="Password"
              password
              value={this.state.password}
              onChange={this.onChange}
              name={'password'}
          />
          <Button onClick={this.onSubmit} node="button">Login</Button>
        </Modal>
    );
  }
}

const mapStateToProps = state => ({
  isAuthenticated: state.auth.isAuthenticated,
  error: state.error
});

export default connect(
  mapStateToProps,
  { login, clearErrors }
)(LoginModal);