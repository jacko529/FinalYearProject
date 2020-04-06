import React, { Component } from 'react';
import {
    Container,
    Form,
    Col,
    FormGroup,
    Label,
    Input,
    FormText,


} from 'reactstrap';

import {
    TextInput,
    Button,
    Row,
} from 'react-materialize';

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
        learningStyle: 'verbal',
        resourceType: 'file/pdf',
        resource: '',
        link: '',
        selectedCourse: '',
        previousSelected: '',
        previous: [],
        course_created: [],
        courseLoaded: false
    };
    componentDidMount() {
        const config = {
            headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}

        };
        axios.get('/courses',config )
            .then(res => {
                this.setState({previous: res.data.data[0]});
                this.setState({courseLoaded: true})
            });

    }

    handleCourse(event) {
        this.setState({selectedCourse: event.target.value})
        console.log(this.state.selectedCourse)
    }
    handleOneCourse(event) {
        this.setState({selectedCourse: event.target.value})
        console.log(this.state.selectedCourse)
    }
    handlePreviousSelected(event) {
        this.setState({previousSelected: event.target.value})

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
        const {  isAuthenticated, user } = this.props.auth;

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
                previous: this.state.previousSelected,
                link: this.state.link
            };



            const json = JSON.stringify(obj);

            const data = new FormData();
            data.append("json", json);
            data.append('file', this.state.resource);

            e.preventDefault();

            console.log(this.state.value)
            axios.post('/coure-resources',data,config )
                .then(res => {
                    window.location.reload();

                });


            console.log('account');
        }
        const reflective = [
            'Reflective learners learn by thinking about information. They prefer to think things through and understand things before acting.'
        ];

        const verbal = [
            'Verbal learners prefer explanations with words – both written and spoken.'
        ];

        const global = [
            'Global learners prefer to organize information more holistically and in a seemingly random manner without seeing connections. They often appear scattered and disorganised in their thinking yet often arrive at a creative or correct end product.'
        ];

        const intuitive = [
            'Intuitive learners prefer to take in information that is abstract, original, and oriented towards theory. They look at the big picture and try to grasp overall patterns. They like discovering possibilities and relationships and working with ideas.'
        ];
            if(isAuthenticated && !user.course_created.isArray){
                this.state.selectedCourse = user.course_created[0].name;

            }

        return (
            <Container style={{textAlign: 'center', marginTop: '4rem'}}>
                <Row>
                    <Form>
                        <Row form>
                            <Col md={12}>
                                {isAuthenticated && !user.course_created.isArray ?
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
                                    <Label for="learning_style">Learning Style</Label>
                                    <Input value={this.state.learningStyle} onChange={this.handleLearningStyleChange.bind(this)} type="select" name="select" id="learning_style">
                                        <option>verbal</option>
                                        <option>intuitive</option>
                                        <option>reflective</option>
                                        <option>global</option>
                                    </Input>
                                </FormGroup>
                            </Col>
                            {this.state.learningStyle === 'verbal'?
                                <p style={{marginLeft:'1rem'}}>{verbal}</p> :null
                            }
                            {this.state.learningStyle === 'intuitive'?
                                <p style={{marginLeft:'1rem'}}>{intuitive}</p> :null
                            }
                            {this.state.learningStyle === 'reflective'?
                                <p style={{marginLeft:'1rem'}}>{reflective}</p> :null
                            }
                            {this.state.learningStyle === 'global'?
                                <p style={{marginLeft:'1rem'}}>{global}</p> :null
                            }


                            {/*<Col md={12}>*/}
                            {/*    {this.state.courseLoaded && this.state.learningStyle !== '' ?*/}
                            {/*        <FormGroup>*/}
                            {/*            <Label for="course">Previous</Label>*/}
                            {/*            <Input value={this.state.previousSelected} onChange={this.handlePreviousSelected.bind(this)} type="select" name="select" id="learning_style">*/}
                            {/*                {this.state.previous.map((course) => <option key={course.course} value={course.course}>*/}
                            {/*                                                                                Resource: {course.course} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*/}
                            {/*                                                                                Stage: {course.stage} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*/}
                            {/*                                                                                Course: {course.resource}</option>)}*/}
                            {/*            </Input>*/}
                            {/*        </FormGroup>*/}
                            {/*        : null }*/}
                            {/*</Col>*/}
                            <Col md={12}>
                                <TextInput label="Resource Name"  value={this.state.resourceName} onChange={this.handleNameChange.bind(this)}/>
                            </Col>
                            <Col md={12}>
                                <p>Remember to keep track of the previous stage you previously uploaded</p>
                                <TextInput label="Stage" type={'number'} value={this.state.stage} onChange={this.handleStageChange.bind(this)}/>
                            </Col>
                            <Col md={12}>
                                <TextInput label="Time" type={'number'} value={this.state.time} onChange={this.handleTimeChange.bind(this)}/>
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
                                    <Col sm={10}>
                                        <TextInput
                                            label=" Click to upload course content."
                                            type="file"
                                            name={'resource'}
                                            id={'resource'}
                                            onChange={this.handleResourceChange.bind(this)}
                                        />
                                    </Col>
                                </FormGroup> :
                                <Col md={12}>
                                    <FormGroup>
                                        <Label for="course_name">Video link</Label>
                                        <Input type="text" value={this.state.link} onChange={this.handleLinkChange.bind(this)}  placeholder="Video link" />
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