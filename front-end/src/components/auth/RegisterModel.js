import React, { Component } from 'react';




import {
  TextInput,

  Button,
  Modal,
} from 'react-materialize';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { register } from '../../actions/authActions';
import { clearErrors } from '../../actions/errorActions';

class RegisterModal extends Component {
  state = {
    first_name: '',
    surname: '',
    email: '',
    password: '',
    msg: null
  };

  static propTypes = {
    isAuthenticated: PropTypes.bool,
    error: PropTypes.object.isRequired,
    register: PropTypes.func.isRequired,
    clearErrors: PropTypes.func.isRequired
  };

  componentDidUpdate(prevProps) {
    const { error, isAuthenticated } = this.props;
    if (error !== prevProps.error) {
      // Check for register error
      if (error.id === 'REGISTER_FAIL') {
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
    e.preventDefault();

    const { first_name, surname, email, password, teacher } = this.state;

    // Create user object
    const newUser = {
      first_name,
      surname,
      email,
      password,
      teacher
    };

    // Attempt to register
    this.props.register(newUser);
  };

  render() {
      const { error } = this.props;

      return (

        <Modal
    actions={[
          <Button flat modal="close" node="button" waves="green">Close</Button>
          ]}
    bottomSheet={false}
    fixedFooter={false}
    header="Register"
    id="modal-0"
    style={{ maxHeight:'80%',   width: '50%', height: 'auto', overflowY: 'inherit'}}
    options={{
      dismissible: true,
          endingTop: '10%',
          inDuration: 250,
          onCloseEnd: null,
          onCloseStart: null,
          onOpenEnd: null,
          onOpenStart: null,
          opacity: 0.5,
          outDuration: 250,
          preventScrolling: true,
          startingTop: '4%'
    }}
    trigger={<Button node="button">Register</Button>}
  >
            <p>{error.msg.access_token}</p>
          <TextInput
              label="First Name"
              value={this.state.first_name}
              onChange={this.onChange}
              name={'first_name'}
          />
          <TextInput
              label="Last Name"
              value={this.state.surname}
              onChange={this.onChange}
              name={'surname'}
          />
          <TextInput
              label="Email"
              value={this.state.username}
              onChange={this.onChange}
              name={'email'}
          />
          <TextInput
              label="Password"
              password
              value={this.state.password}
              onChange={this.onChange}
              name={'password'}
          />
              <Button onClick={this.onSubmit} color='dark' style={{ marginTop: '2rem' }} >
                Register
              </Button>
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
  { register, clearErrors }
)(RegisterModal);