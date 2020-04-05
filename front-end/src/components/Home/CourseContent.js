import React from 'react';

import {

    Container,
    Row,
    Button
} from 'react-materialize';
import '../../Loader.css';
import '../../SidePanel.css';
import './Tiles'

import Timer from "react-compound-timer";
import 'react-rangeslider/lib/index.css'
import axios from 'axios';

import Iframe from "react-iframe";
import {
    Link
} from "react-router-dom";
const CourseContent = (props) => {

    console.log(props);
    let save = (e) => {
        e.preventDefault();
        console.log('account');
        const config = {
            headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}
        };

        const body = JSON.stringify({ name_of_resource: props.location.state.title,
                                             email: props.location.state.email,

                                           }
                                             );

        axios.post('/consume',body,config )
            .then(res => {
                // window.location.href = '/me';
            });
        {const lop = 0}
        // this.props.add  = 0;
    }
    const minutes = Math.floor(props.location.state.time * 60 * 1000);
            return (
                <Container style={{textAlign: 'center'}}>
                    <h1 style={{marginTop: '3rem' , marginBottom: '1.5rem'}}>{props.location.state.title}</h1>
                    <Timer
                        initialTime={minutes}
                        direction="backward"
                        checkpoints={[
                            {
                                time: 0,
                                callback: () => save(),
                            }]}
                        formatValue={(value) => `${(value < 10 ? `0${value}` : value)}  `
                        }>

                            {({getTimerState, getTime}) => (
                            <div>

                            <Timer.Hours  />
                        <Timer.Minutes />
                        <Timer.Seconds  />
                                {/*{const lop = 0}*/}
                                {  }

                            </div>
                        )}

                    </Timer>
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