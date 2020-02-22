import React, { Component, Fragment } from 'react';
import {
    ListGroup,
    ListGroupItem,
    Container,
    Row,
    Button
} from 'reactstrap';
import '../../Loader.css';
import '../../SidePanel.css';
import './Tiles'
import Tiles from "./Tiles";


import 'react-rangeslider/lib/index.css'
import axios from 'axios';

import { connect } from 'react-redux';
import Iframe from "react-iframe";


export class CourseContent extends Component {

    state = {
        requestCompleted:false,
        learning_styles: [],
        course: [],
        value: 10,

    };

    render() {



            return (
                <Container>
                    <Row>
                        <Iframe url="http://www.youtube.com/embed/xDMP3i36naA"
                                width="100%"
                                height="500px"
                                id="myId"
                                className="myClassname"
                                display="initial"
                                position="relative"/>
                    </Row>
                </Container>
            );
        }

}



const mapStateToProps = state => ({
    auth: state.auth
});

export default connect(
    mapStateToProps,
    null
)(CourseContent);