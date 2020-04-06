import axios from 'axios';
import { returnErrors } from './errorActions';

import {
  USER_LOADED,
  USER_LOADING,
  AUTH_ERROR,
  LOGIN_SUCCESS,
  LOGIN_FAIL,
  LOGOUT_SUCCESS,
  REGISTER_SUCCESS,
  REGISTER_FAIL
} from './types';

// Check token & load user
export const loadUser = () => (dispatch, getState) => {
  // User Loading
  dispatch({ type: USER_LOADING });

  axios
      .post('/me', '', tokenConfig(getState))
      .then(res =>
          dispatch({
            type: USER_LOADED,
            payload: res.data
          })
      )
      .catch(err => {

              console.log(err.response)
              dispatch(returnErrors(err.response.data, err.response.status));
              dispatch({
                  type: AUTH_ERROR
              });

      });
};

// Register User
export const register = ({ first_name, surname, email, password }) => dispatch => {
  // Headers
  const config = {
    headers: {
      'Content-Type': 'application/json'
    }
  };

  // Request body
  const body = JSON.stringify({ first_name, surname, email, password });

  axios
      .post('/register', body, config)
      .then(res =>
          dispatch({
            type: REGISTER_SUCCESS,
            payload: res.data
          })
      )
      .catch(err => {
        dispatch(
            returnErrors(err.response.data, err.response.status, 'REGISTER_FAIL')
        );
        dispatch({
          type: REGISTER_FAIL
        });
      });
};

// Login User
export const login = ({ username, password }) => dispatch => {
  // Headers
  const config = {
    headers: {
      'Content-Type': 'application/json'
    }
  };

  // Request body
  const body = JSON.stringify({ username, password });

  axios
      .post('/login', body, config)
      .then(res =>
          dispatch({
            type: LOGIN_SUCCESS,
            payload: res.data
          })
      ).then(res =>
      localStorage.setItem('access_token', res.payload.access_token)
  )
      .catch(err => {
              dispatch(returnErrors(err.response.data, err.response.status));
              dispatch({
          type: LOGIN_FAIL
        });

      });
};

// Logout User
export const logout = () => {
  return {
    type: LOGOUT_SUCCESS
  };
};

// Setup config/headers and token
export const tokenConfig = getState => {
  // Get token from localstorage
  const access_token = localStorage.getItem('access_token');

  // Headers
  const config = {
    headers: {
      'Content-type': 'application/json',

    }
  };

  // If token, add to headers
  if (access_token) {
    config.headers['Authorization'] =  `bearer ${access_token}`;
  }
  return config;
};