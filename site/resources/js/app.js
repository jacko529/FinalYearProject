import Highway from "@dogstudio/highway";
import Fade from './transition';
import axios from 'axios';

const H = new Highway.Core({
    transitions: {
        home: Fade,
        about: Fade
    }
});

const form = document.querySelector('#form');

const formEvent = form.addEventListener('submit', async event => {
    event.preventDefault();

    const firstName = document.querySelector('#first-name').value;
    const surname = document.querySelector('#surname').value;
    const emailAddress = document.querySelector('#email').value;
    const password = document.querySelector('#password').value;
    const repeatPassword = document.querySelector('#password-repeat').value;

    const user = {
        firstName,
        surname,
        emailAddress,
        password,
        repeatPassword
    };
    console.log(user);

    try {

        const res = await axios.post('/api/create', user);
        const createUserBlob = res.data;
        console.log(`furthers !`);

        console.log(`Added a new user!`, createUserBlob);

        return createUser;
    } catch (e) {
        console.error(e);
    }
});
const createUser = async (user) => {

};

