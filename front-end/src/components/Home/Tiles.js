import React, { Component, Fragment } from 'react';
import {
    Card, CardImg, CardText,Col, CardBody, Row,
    CardTitle, CardSubtitle, Button
} from 'reactstrap';
import '../../SidePanel.css';

import {
    Link
} from "react-router-dom";
import Logout from "../auth/Logout";

const Tiles = (props) => {
    let save = (e) => {
        e.preventDefault();
        console.log('account');
    }

    return (
                <Col sm={{ size: '12' }} md={{ size: '4' , offset: '1'}}>
                <Card>
                    <CardImg top width="20%" src={props.image} alt="" />
                    <CardBody>
                        <CardTitle>{props.title}</CardTitle>
                        <CardSubtitle>{props.subtitle}</CardSubtitle>
                        <CardText>Global {props.learning_styles.global}</CardText>
                        <CardText>Intuitive {props.learning_styles.intuitive}</CardText>
                        <CardText>Reflector {props.learning_styles.reflector}</CardText>
                        <CardText>Verbal {props.learning_styles.verbal}</CardText>
                        {(props.button === null) ? null : (props.learning_styles !== null ) ? null : <Button  onClick={save}><Link to="/quiz">{props.button}</Link></Button>}
                    </CardBody>
                </Card>
                </Col>
    );
};

export default Tiles;