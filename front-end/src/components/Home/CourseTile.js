import React from 'react';


import { Button, Card, CardTitle,Icon, Row, Col } from 'react-materialize';
import 'materialize-css'
import '../../SidePanel.css';

import {
    Link
} from "react-router-dom";

const CourseTile = (props) => {
    let save = (e) => {
        e.preventDefault();
    }
    console.log('tile', props);

    return (

        <Col   m={2}
               s={6}>
            <Card
                actions={[
                   <Button><Link to={{
                        pathname:"/content",
                        state: {
                            url: props.url,
                            title: props.title,
                            email: props.email,
                            time: props.time
                        }}}> {props.button}</Link></Button>
                ]}
                header={<CardTitle image={props.image}>{props.title}</CardTitle>}
                revealIcon={<Icon>more_vert</Icon>}

            >
                Title - {props.title}<br></br>
                Course - {props.course}<br></br>
                Stage - {props.stage}<br></br>
                Should take - {props.time} minutes<br></br>

            </Card>
        </Col>

    );
};

export default CourseTile;