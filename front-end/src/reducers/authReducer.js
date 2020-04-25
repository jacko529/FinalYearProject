import {
    AUTH_ERROR,
    LOGIN_FAIL,
    LOGIN_SUCCESS,
    LOGOUT_SUCCESS,
    REGISTER_FAIL,
    REGISTER_SUCCESS,
    USER_LOADED,
    USER_LOADING
} from '../actions/types';

const initialState = {
    access_token: localStorage.getItem('access_token'),
    isAuthenticated: null,
    isLoading: false,
    isLoaded: false,
    user: null,
    isUser: false,
    isTeacher: false
};

export default function (state = initialState, action) {
    switch (action.type) {
        case USER_LOADING:
            return {
                ...state,
                isLoading: true
            };
        case USER_LOADED:
            const type = action.payload.user_type;
            if (!type.includes("ROLE_TEACHER")) {
                return {
                    ...state,
                    isAuthenticated: true,
                    isLoading: false,
                    isLoaded: true,
                    user: action.payload,
                    isUser: true,
                    isTeacher: false
                };
            } else {
                return {
                    ...state,
                    isAuthenticated: true,
                    isLoading: false,
                    isLoaded: true,
                    user: action.payload,
                    isUser: true,
                    isTeacher: true
                };
            }
        case LOGIN_SUCCESS:
        case REGISTER_SUCCESS:
            localStorage.setItem('access_token', action.payload.access_token);
            return {
                ...state,
                ...action.payload,
                isAuthenticated: true,
                isLoaded: true,
                isLoading: false
            };
        case AUTH_ERROR:
        case LOGIN_FAIL:
        case LOGOUT_SUCCESS:
        case REGISTER_FAIL:
            localStorage.removeItem('access_token');
            return {
                ...state,
                access_token: null,
                user: null,
                isAuthenticated: false,
                isLoading: false,
                isLoaded: true
            };
        default:
            return state;
    }
}