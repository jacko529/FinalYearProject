import React from 'react';

import { Button, Card, CardTitle,Icon, Row, Col } from 'react-materialize';
import 'materialize-css'
import '../../SidePanel.css';

import {
    Link
} from "react-router-dom";

const NoCourseTile = (props) => {
    let save = (e) => {
        e.preventDefault();
    }
    console.log('tile', props.url);
    return (

        <Col   m={2}
               s={6}>
            <Card
                actions={[

                ]}
                header={<CardTitle image={props.image}>{props.title}</CardTitle>}
                revealicon={<Icon>more_vert</Icon>}

            >

                There will be more courses to come
                </Card>


        </Col>

    );
};

export default NoCourseTile;