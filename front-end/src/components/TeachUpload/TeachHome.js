import React, { Component, Fragment } from 'react';
import {
    ListGroup,
    ListGroupItem,
    Container,
    Row,
    Button,
    Col,
    FormGroup,
    Label,
    Form,
    Input,
    FormText
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
        values: '',

    };
    handleChange(event) {
        this.setState({values: event.target.value})
    }
    render() {
        let save = (e) => {
            const config = {
                headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}
            };
            e.preventDefault();
            const body = JSON.stringify({ name: this.state.values });
            console.log(this.state.value)
            axios.post('http://localhost:8080/api/course',body,config )
                .then(res => {
                    console.log(res.data);

                });


            console.log('account');
        }



        return (
            <Container>
                <Row>
                    <Form>
                        <Row form>
                            <Col md={12}>
                                <FormGroup>
                                    <Label for="course_name">Course Name</Label>
                                    <Input type="text" value={this.state.values} onChange={this.handleChange.bind(this)}  placeholder="networking" />
                                </FormGroup>
                            </Col>
                            <FormGroup row>
                                <Label for="course_image" sm={2}>File</Label>
                                <Col sm={10}>
                                    <Input type="file" name="course_image" id="course_image" />
                                    <FormText color="muted">
                                        This is the course placeholder image.
                                    </FormText>
                                </Col>
                            </FormGroup>
                        </Row>
                        <Button onClick={save}>Sign in</Button>
                    </Form>

                </Row>
                <Row>
                    <Button>
                        <Link to="/upload-content">Upload course content</Link>
                    </Button>
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