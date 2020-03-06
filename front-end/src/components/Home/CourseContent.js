import React from 'react';

import {

    Container,
    Row,
    Button
} from 'react-materialize';
import '../../Loader.css';
import '../../SidePanel.css';
import './Tiles'


import 'react-rangeslider/lib/index.css'
import axios from 'axios';

import Iframe from "react-iframe";
import {
    Link
} from "react-router-dom";
const CourseContent = (props) => {
    console.log(props.location.state.url);
    let save = (e) => {
        e.preventDefault();
        console.log('account');
        const config = {
            headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}
        };

        const body = JSON.stringify({ name_of_resource: props.location.state.title,
                                             email: props.location.state.email}
                                             );

        axios.post('/consume',body,config )
            .then(res => {
                console.log(res.data);
            });
        window.location.href = '/me';

    }

            return (
                <Container style={{textAlign: 'center'}}>
                    <h1 style={{marginTop: '3rem' , marginBottom: '1.5rem'}}>{props.location.state.title}</h1>

                    <Row >
                        <Iframe url={props.location.state.url}
                                width="100%"
                                height="500px"
                                id="myId"
                                className="myClassname"
                                display="initial"
                                position="relative"/>{props.url}
                    </Row>

                    <Button onClick={save}> Finished</Button>
                </Container>
            );


}


export default CourseContent;