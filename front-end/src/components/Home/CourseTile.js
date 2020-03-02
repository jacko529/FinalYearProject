import React from 'react';
// import {
//     Card, CardImg, CardText,Col, CardBody,
//     CardTitle, CardSubtitle, Button
// } from 'reactstrap';

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
    console.log('tile', props.url);
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
                            email: props.email
                        }}}> {props.button}</Link></Button>
                ]}
                header={<CardTitle image={props.image}>{props.title}</CardTitle>}
                revealIcon={<Icon>more_vert</Icon>}

            >
                Title - {props.title}<br></br>
                    Course - {props.course}<br></br>
                  Stage - {props.stage}<br></br>

            </Card>
        </Col>

    );
};

export default CourseTile;