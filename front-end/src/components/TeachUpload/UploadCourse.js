import React, { Component } from 'react';

import {
    Button,
    TextInput,
    Container,
    Row,
    Col,
    Form
} from 'react-materialize';
import {
    Link
} from "react-router-dom";
import '../../Loader.css';
import '../../SidePanel.css';

import 'react-rangeslider/lib/index.css'
import axios from 'axios';

import { connect } from 'react-redux';
import InformCards from "../Home/InformCards";


export class UploadCourse extends Component {

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
        const {isTeacher,isUser, isLoading, isAuthenticated, user } = this.props.auth;

        let save = (e) => {
            const config = {
                headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}
            };
            e.preventDefault();
            const body = JSON.stringify({ name: this.state.values });
            console.log(this.state.value)
            axios.post('/course',body,config )
                .then(res => {
                    console.log(res.data);

                });
        }

        return (
            <Container style={{textAlign:'center' , marginTop: '5rem'}}>

                <Col md={12}>
                    <Row>
                        <TextInput label="Course Name"  value={this.state.values} onChange={this.handleChange.bind(this)}/>
                    </Row>
                    <Row>
                        <TextInput
                            label=" This is the course placeholder image."
                            type="file"
                            name={'course_image'}
                            id={'course_image'}
                        />
                    </Row>

                </Col>
                <Row style={{textAlign: 'center' , display: 'inherit'}}>
                    <Button onClick={save}>Name Course</Button>
                </Row>
                <Row style={{textAlign: 'center' , display: 'inherit'}}>
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
)(UploadCourse);