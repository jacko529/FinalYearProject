import axios from 'axios';
import { returnErrors } from './errorActions';

import {
    NEXT_ACTIVE_LOADED,
    NEXT_ACTIVE_LOADING,
    AUTH_ERROR
} from './types';

// Check token & load user
export const nextActiveLoading = () => (dispatch, getState) => {
    // User Loading
    dispatch({ type: NEXT_ACTIVE_LOADING });

    axios
        .get('http://localhost:8080/api/next-active',  tokenConfig(getState))
        .then(res =>
            dispatch({
                type: NEXT_ACTIVE_LOADED,
                payload: res.data
            })
        )
        .catch(err => {
            dispatch(returnErrors(err.response.data, err.response.status));
            dispatch({
                type: AUTH_ERROR
            });
        });
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