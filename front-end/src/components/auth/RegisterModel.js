import React, { Component } from 'react';
import {
  Form,
  FormGroup,
  Alert
} from 'reactstrap';
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
    return (
      <div className='hide-register'>
          <div toggle={this.toggle}>Register</div>
            {this.state.msg ? (
              <Alert color='danger'>{this.state.msg}</Alert>
            ) : null}
            <Form onSubmit={this.onSubmit}>
              <FormGroup>
                <label for='first_name'>Name</label>
                <input
                    type='text'
                    name='first_name'
                    id='first_name'
                    placeholder='First name'
                    className='mb-3'
                    onChange={this.onChange}
                />

                <label for='surname'>Surname</label>
                <input
                    type='text'
                    name='surname'
                    id='surname'
                    placeholder='Surname'
                    className='mb-3'
                    onChange={this.onChange}
                />

                <label for='email'>Email</label>
                <input
                  type='email'
                  name='email'
                  id='email'
                  placeholder='Email'
                  className='mb-3'
                  onChange={this.onChange}
                />

                <label for='password'>Password</label>
                <input
                  type='password'
                  name='password'
                  id='password'
                  placeholder='Password'
                  className='mb-3'
                  onChange={this.onChange}
                />
                <button color='dark' style={{ marginTop: '2rem' }} block>
                  Register
                </button>
              </FormGroup>
            </Form>
      </div>
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