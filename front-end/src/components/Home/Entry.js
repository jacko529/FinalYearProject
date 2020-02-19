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
import NormalTile from "./NormalTile";
import CourseTile from "./CourseTile";
import Slider from 'react-rangeslider'

import 'react-rangeslider/lib/index.css'
import axios from 'axios';

import { connect } from 'react-redux';


export class Entry extends Component {

    state = {
        requestCompleted:false,
        learning_styles: [],
        course: [],
        value: 10,

    };
    componentDidMount() {
        const config = {
            headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}

        };

        axios.get('http://localhost:8080/api/next-active',config )
            .then(res => {
                console.log(res.data);
                this.setState({course: res.data});
                this.setState({requestCompleted: true})
            });

    }
    handleChangeStart = () => {
        console.log('Change event started')
    };
    handleSliderChange = value => {
        this.setState({
            value: value
        })
    };
    handleChangeComplete = () => {
        console.log('Change event completed')
    };
    render() {
        const { isLoading, isAuthenticated, user } = this.props.auth;
        let save = (e) => {
            const config = {
                headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}
            };
            e.preventDefault();
            const body = JSON.stringify({ time: this.state.value });

            axios.post('http://localhost:8080/api/user-time',body,config )
                .then(res => {
                    console.log(res.data);
                });

            console.log('account');
        }

        const welcome = (
                <Fragment>
                    <Container>
                        <h1 style={{textAlign: "center"}}>Welcome to easy learning</h1>

                        <ListGroup>
                            <ListGroupItem>
                                First select the a course
                            </ListGroupItem>
                            <ListGroupItem>
                                Find out your learning style
                            </ListGroupItem>
                            <ListGroupItem>
                                Say how much time you have
                            </ListGroupItem>
                            <ListGroupItem>
                                Work through course
                            </ListGroupItem>
                        </ListGroup>
                    </Container>
                </Fragment>
        );
        if (!isAuthenticated && !this.state.requestCompleted){
            return (

                <div>
                <Container>
                    {welcome}
                    <Row className="bottom-row">

                        <NormalTile
                            image={"/"}
                            title={"Random Users"}
                            subtitle={'Here are your results'}
                            description={'It will help'}
                            button={'TakeQuiz'}
                        />

                    </Row>
                </Container>

            </div>
            )
        }else {
            const { value } = this.state

            return (
                <div>
                    <Container>

                        {welcome}
                        {user.time ? <Slider
                            min={0}
                            max={100}
                            value={value}
                            onChangeStart={this.handleChangeStart}
                            onChange={this.handleSliderChange}
                            onChangeComplete={this.handleChangeComplete}
                        /> : null }
                        {user.time ?  <div className='value'>{value}</div> : null}
                        {user.time ? <Button onClick={save} >That's enough time</Button>: null}

                        <Row  className="bottom-row">

                            <Tiles
                                image={"/brainprocess.jpg"}
                                title={"Random Users"}
                                learning_styles={user.learning_styles}
                                subtitle={'Here are your results'}
                                description={'It will help'}
                                button={'TakeQuiz'}
                            />
                            {user.learning_styles ?
                            <CourseTile
                                image={"/brainprocess.jpg"}
                                title={"Random Users"}
                                course={this.state.course}
                                button={'Start Course'}
                            /> : null}
                        </Row>
                    </Container>
                </div>
            );
        }
    }
}



const mapStateToProps = state => ({
    auth: state.auth
});

export default connect(
    mapStateToProps,
    null
)(Entry);