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
        course_image: '',
    };
    handleChange(event) {
        this.setState({values: event.target.value})
    }
    handleResourceChange(event) {
        this.setState({course_image: event.target.files[0]})

    }
    render() {
        const {isTeacher,isUser, isLoading, isAuthenticated, user } = this.props.auth;

        let save = (e) => {
            const config = {
                headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,
                    'Accept': 'application/json',
                    'Content-Type': 'multipart/form-data',
                }
            };
            e.preventDefault();
            const body = JSON.stringify({ name: this.state.values });


            // const json = JSON.stringify(body);

            const data = new FormData();
            data.append("json", body);
            data.append('file', this.state.course_image);


            console.log(this.state.value)
            axios.post('/course',data,config )
                .then(res => {
                    window.location.reload();
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
                            onChange={this.handleResourceChange.bind(this)}
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