import {
    NEXT_ACTIVE_LOADED,
    NEXT_ACTIVE_LOADING,
    AUTH_ERROR
} from '../actions/types';

const initialState = {
    access_token: localStorage.getItem('access_token'),
    isAuthenticated: null,
    nextActiveLoaded: false,
    nextActiveLoading: false
};

export default function(state = initialState, action) {
    switch (action.type) {
        case NEXT_ACTIVE_LOADING:
            return {
                ...state,
                nextActiveLoading: true
            };
        case NEXT_ACTIVE_LOADED:
                return {
                    ...state,
                    isAuthenticated: true,
                    nextActiveLoaded: true,
                    nextActiveLoading: false
                };
        case AUTH_ERROR:
            localStorage.removeItem('access_token');
            return {
                ...state,
                access_token: null,
                isAuthenticated: false,
                nextActiveLoaded: true,
                nextActiveLoading: false
            };
        default:
            return state;
    }
}