import React, { Component, Fragment } from 'react';
import {

    Container,
    Row,

} from 'reactstrap';
import {
    Link
} from "react-router-dom";
import '../../Loader.css';
import '../../SidePanel.css';

import Slider from 'react-rangeslider'

import 'react-rangeslider/lib/index.css'
import axios from 'axios';

import { connect } from 'react-redux';


export class TeachHome extends Component {

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
)(TeachHome);