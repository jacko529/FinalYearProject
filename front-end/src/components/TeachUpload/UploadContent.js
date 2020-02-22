import React, { Component, Fragment } from 'react';
import {
    Container,
    Form,
    Col,
    FormGroup,
    Label,
    Input,
    FormText,
    Row,
    Button
} from 'reactstrap';

import '../../Loader.css';
import '../../SidePanel.css';

import 'react-rangeslider/lib/index.css'
import axios from 'axios';

import { connect } from 'react-redux';


export class TeachHome extends Component {

    state = {
        resourceName: '',
        stage: '',
        time: '',
        learningStyle: '',
        resourceType: 'file/pdf',
        resource: '',
        link: '',
        selectedCourse: '',
        previous: []
    };
    handleCourse(event) {
        this.setState({selectedCourse: event.target.value})
    }
    handleNameChange(event) {
        this.setState({resourceName: event.target.value})
    }
    handleStageChange(event) {
        this.setState({stage: event.target.value})
    }
    handleTimeChange(event) {
        this.setState({time: event.target.value})
    }
    handleLearningStyleChange(event) {
        this.setState({learningStyle: event.target.value})
    }
    handleResourceTypeChange(event) {
        this.setState({resourceType: event.target.value})
    }
    handleLinkChange(event) {
        this.setState({link: event.target.value})
    }
    handleResourceChange(event) {
        this.setState({resource: event.target.files[0]})

    }
    render() {
        const { isLoading, isAuthenticated, user } = this.props.auth;

        let save = (e) => {
            const config = {
                headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            };

            const obj = {
                selectedCourse: this.state.selectedCourse,
                resourceName: this.state.resourceName,
                stage: this.state.stage,
                time: this.state.time,
                learning_style: this.state.learningStyle,
                previous: this.state.previous
            };
            const json = JSON.stringify(obj);

            const data = new FormData();
            data.append("json", json);
            data.append('file', this.state.resource);

            e.preventDefault();

            console.log(this.state.value)
            axios.post('http://localhost:8080/api/coure-resources',data,config )
                .then(res => {
                    console.log(res.data);

                });
            this.state = {resourceName: '',
                stage: '',
                time: '',
                learningStyle: '',
                resourceType: 'file/pdf',
                resource: '',
                link: '',
                previous: [],
                courses: [],
                selectedCourse: ""

            };

            console.log('account');
        }


        return (
            <Container>
                <Row>
                    <Form>
                        <Row form>
                            <Col md={12}>
                                {isAuthenticated ?
                                <FormGroup>
                                    <Label for="course">Which course</Label>
                                    <Input value={this.state.selectedCourse} onChange={this.handleCourse.bind(this)} type="select" name="select" id="learning_style">
                                        {user.course_created.map((course) => <option key={course.name} value={course.name}>{course.name}</option>)}
                                    </Input>
                                </FormGroup>
                                    : null }
                            </Col>
                            <Col md={12}>
                                <FormGroup>
                                    <Label for="resource_name">Resource Name</Label>
                                    <Input type="text" value={this.state.resourceName} onChange={this.handleNameChange.bind(this)}  placeholder="Resource name" />
                                </FormGroup>
                            </Col>
                            <Col md={12}>
                                <FormGroup>
                                    <Label for="stage">Stage</Label>
                                    <Input type="number" value={this.state.stage} onChange={this.handleStageChange.bind(this)}  placeholder="Stage in the course" />
                                </FormGroup>
                            </Col>
                            <Col md={12}>
                                <FormGroup>
                                    <Label for="time">Time</Label>
                                    <Input type="number" value={this.state.time} onChange={this.handleTimeChange.bind(this)}  placeholder="time" />
                                </FormGroup>
                            </Col>
                            <Col md={12}>
                                <FormGroup>
                                    <Label for="learning_style">Learning Style</Label>
                                    <Input value={this.state.learningStyle} onChange={this.handleLearningStyleChange.bind(this)} type="select" name="select" id="learning_style">
                                        <option>verbal</option>
                                        <option>intuitive</option>
                                        <option>reflective</option>
                                        <option>global</option>
                                    </Input>
                                </FormGroup>
                            </Col>
                            <Col md={12}>
                                <FormGroup>
                                    <Label for="resource_type">Resource</Label>
                                    <Input type="select" value={this.state.resourceType} onChange={this.handleResourceTypeChange.bind(this)} name="select" id="resource_type">
                                        <option>file/pdf</option>
                                        <option>video link</option>
                                    </Input>
                                </FormGroup>
                            </Col>
                            {this.state.resourceType === 'file/pdf' ?
                                <FormGroup row>
                                    <Label for="resource" sm={2}>Resource</Label>
                                    <Col sm={10}>
                                        <Input type="file" onChange={this.handleResourceChange.bind(this)} name="resource" id="resource" />
                                        <FormText color="muted">
                                            This is the course content.
                                        </FormText>
                                    </Col>
                                </FormGroup> :
                                <Col md={12}>
                                    <FormGroup>
                                        <Label for="course_name">Video link</Label>
                                        <Input type="number" value={this.state.link} onChange={this.handleLinkChange.bind(this)}  placeholder="Video link" />
                                    </FormGroup>
                                </Col>

                            }

                        </Row>
                        <Button onClick={save}>Confirm</Button>
                    </Form>

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