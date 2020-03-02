import React, { Component, Fragment } from 'react';
import { Button, Container,TextInput,Select, Collection,Range, CollectionItem,Card, CardTitle,Icon, Row, Col } from 'react-materialize';
import 'materialize-css'
import '../../Loader.css';
import '../../SidePanel.css';
import './Tiles'
import Tiles from "./Tiles";
import NormalTile from "./NormalTile";
import CourseTile from "./CourseTile";

import axios from 'axios';

import { connect } from 'react-redux';
import NoCourseTile from "./NoCourseTile";
import Loader from "react-loader-spinner";
import { Graph } from "react-d3-graph";



export class Entry extends Component {

    state = {
        requestCompleted:false,
        learning_styles: [],
        course: [],
        value: 10,
        url: '',
        rangeValue: '',
        explainShortPath: [],
        coursesCanChoose: [],
        selectedCourse: '',
        recommendation: [],
        noCourse: []
    };
    componentWillMount() {


        const config = {
            headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}

        };

        axios.get('http://localhost:8080/api/next-active',config )
            .then(res => {
                if(!res.data['shortest_path'] || !res.data['jarrard']){
                    this.setState({noCourse: res.data['none'][0]});

                }else{
                    console.log('request', res.data['explain_short_path'][0])

                    this.setState({course: res.data['shortest_path'][0]});
                    this.setState({recommendation: res.data['jarrard'][0]});
                    this.setState({explainShortPath: res.data['explain_short_path'][0]});

                }

                this.setState({requestCompleted: true});
            }).then(
            axios.get('http://localhost:8080/api/courses',config )
                .then(ress => {
                    this.setState({coursesCanChoose: ress.data.data});

                })
        );

    }



    handleCourse(event) {
        this.setState({coursesCanChoose: event.target.value})
    }

    handleRangeSlider(event) {
        this.setState({rangeValue: event.target.value})
    }


    render() {
        const data = {
            nodes: [{ id: "Harry" }, { id: "Sally" }, { id: "Alice" }],
            links: [{ source: "Harry", target: "Sally" }, { source: "Harry", target: "Alice" }],
        };



// the graph configuration, you only need to pass down properties
// that you want to override, otherwise default ones will be used
        const myConfig = {
            nodeHighlightBehavior: true,
            node: {
                color: "lightblue",
                size: 420,
                fontColor: 'lightblue',
                highlightStrokeColor: "blue",
            },
            link: {
                highlightColor: "blue",
            },
        };

        // graph event callbacks
        const onClickGraph = function() {
            window.alert(`Clicked the graph background`);
        };

        const onClickNode = function(nodeId) {
        };

        const onDoubleClickNode = function(nodeId) {
            window.alert(`Double clicked node ${nodeId}`);
        };

        const onRightClickNode = function(event, nodeId) {
            window.alert(`Right clicked node ${nodeId}`);
        };

        const onMouseOverNode = function(nodeId) {
        };

        const onMouseOutNode = function(nodeId) {
        };

        const onClickLink = function(source, target) {
        };

        const onRightClickLink = function(event, source, target) {
        };

        const onMouseOverLink = function(source, target) {
        };

        const onMouseOutLink = function(source, target) {
        };

        const onNodePositionChange = function(nodeId, x, y) {
        };
        const {isTeacher,isUser, isLoading, isAuthenticated, user } = this.props.auth;
        // const {isTeacher,isUser, isLoading, isAuthenticated, user } = this.props.auth;



        let saveCourse = (e) =>{
            const config = {
                headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}
            };
            e.preventDefault();

            const body = JSON.stringify({ course: this.state.coursesCanChoose[0] });

            axios.post('http://localhost:8080/api/courses',body,config )
                .then(res => {
                    // console.log(res.data);

                });
        }
        let save = (e) => {
            const config = {
                headers: { Authorization: `bearer ${localStorage.getItem('access_token')}` ,'Content-type': 'application/json'}
            };
            e.preventDefault();
            const body = JSON.stringify({ time: this.state.rangeValue });

            axios.post('http://localhost:8080/api/user-time',body,config )
                .then(res => {

                });


        }

        const welcome = (
                <Fragment>
                        <h1 style={{textAlign: "center",marginBottom: "2rem" , marginTop: '4rem', color: 'white'}}>Welcome to Easy Learn</h1>

                        <Collection>
                            <CollectionItem>
                                First select the a course
                            </CollectionItem>
                            <CollectionItem>
                                Find out your learning style
                            </CollectionItem>
                            <CollectionItem>
                                Work through course
                            </CollectionItem>
                        </Collection>
                </Fragment>
        );


        const { value } = this.state
        if(this.state.requestCompleted){
            // {this.explainShortPath.map((course) => console.log(course) )}
            console.log(this.state.explainShortPath.first)
        }
        const loadingSign = (
            <div className={this.state.requestCompleted ? 'normal' : 'loader  '} style={{textAlign:'center'}}>
                <Loader
                    type="MutatingDots"
                    color="#00BFFF"
                    height={80}
                    width={80}
                    timeout={500} //3 secs
                />
            </div>
        );
        return (

            <div>
                {!this.state.requestCompleted ? loadingSign :
                <Container>

                    {welcome}

                    { this.state.noCourse.length > 0  && Object.keys(user.learning_styles).length > 1 ?

                        <Row  className="bottom-row">

                            <Tiles
                                image={"/audo.jpg"}
                                title={user.first_name + ' ' + user.surname}
                                learning_styles={user.learning_styles}
                                subtitle={'Here are your results'}
                                description={'It will help'}
                                button={'TakeQuiz'}
                            />

                            <NoCourseTile
                                image={"/study-notebooks.jpg"}
                                title={this.state.noCourse}
                            />



                        </Row> : null

                    }
                    {/* this is to check that the user is authenticated, has learning styles and request has been made*/}
                    {this.state.noCourse.length === 0  && Object.keys(user.learning_styles).length > 1  ?

                        <Row  className="bottom-row">

                            <Tiles
                                image={"/audo.jpg"}
                                title={user.first_name + ' ' + user.surname}
                                learning_styles={user.learning_styles}
                                subtitle={'Here are your results'}
                                description={'It will help'}
                                button={'TakeQuiz'}
                            />


                            {user.learning_styles ?
                                <CourseTile
                                    image={"/study.jpg"}
                                    title={this.state.course.name_of_resource}
                                    stage={this.state.course.stage}
                                    course={this.state.coursesCanChoose}
                                    url={this.state.course.url}
                                    email={user.email}
                                    button={'Start Course'}
                                /> : null}

                                { this.state.recommendation ?

                                        <CourseTile
                                    image={"/study-notebooks.jpg"}
                                    title={this.state.recommendation.name_of_resource}
                                    stage={this.state.recommendation.stage}
                                    course={this.state.coursesCanChoose}
                                    url={this.state.course.url}
                                    email={user.email}
                                    button={'Your Friends took this'}
                                />  :null}
                                <h3>What is your learning path </h3>
                            <Graph
                                id="graph-id" // id is mandatory, if no id is defined rd3g will throw an error
                                data={this.state.explainShortPath.first}
                                config={myConfig}
                                onClickNode={onClickNode}
                                onDoubleClickNode={onDoubleClickNode}
                                onRightClickNode={onRightClickNode}
                                onClickGraph={onClickGraph}
                                onClickLink={onClickLink}
                                onRightClickLink={onRightClickLink}
                                onMouseOverNode={onMouseOverNode}
                                onMouseOutNode={onMouseOutNode}
                                onMouseOverLink={onMouseOverLink}
                                onMouseOutLink={onMouseOutLink}
                                onNodePositionChange={onNodePositionChange}
                            />;
                            <Graph
                                id="graph-id" // id is mandatory, if no id is defined rd3g will throw an error
                                data={this.state.explainShortPath.second}
                                config={myConfig}
                                onClickNode={onClickNode}
                                onDoubleClickNode={onDoubleClickNode}
                                onRightClickNode={onRightClickNode}
                                onClickGraph={onClickGraph}
                                onClickLink={onClickLink}
                                onRightClickLink={onRightClickLink}
                                onMouseOverNode={onMouseOverNode}
                                onMouseOutNode={onMouseOutNode}
                                onMouseOverLink={onMouseOverLink}
                                onMouseOutLink={onMouseOutLink}
                                onNodePositionChange={onNodePositionChange}
                            />;
                            <Graph
                                id="graph-id" // id is mandatory, if no id is defined rd3g will throw an error
                                data={this.state.explainShortPath.third}
                                config={myConfig}
                                onClickNode={onClickNode}
                                onDoubleClickNode={onDoubleClickNode}
                                onRightClickNode={onRightClickNode}
                                onClickGraph={onClickGraph}
                                onClickLink={onClickLink}
                                onRightClickLink={onRightClickLink}
                                onMouseOverNode={onMouseOverNode}
                                onMouseOutNode={onMouseOutNode}
                                onMouseOverLink={onMouseOverLink}
                                onMouseOutLink={onMouseOutLink}
                                onNodePositionChange={onNodePositionChange}
                            />;

                        </Row> : null

                    }




                    { Object.keys(user.learning_styles).length < 1 ?

                        <div  className="bottom-row" style={{textAlign: 'center'}} >
                            <Row
                            >
                            <Col m={6}
                                  s={6}>
                                    <h1>Student Information</h1>
                                    <Range
                                        value={this.state.rangeValue}
                                        onChange={this.handleRangeSlider.bind(this)}
                                        max="100"
                                        min="0"
                                        name="points"
                                    />
                                    {user.time === '' ? <Button onClick={save} >That's enough time</Button>: null}
                            </Col>
                                </Row>
                                <Row >
                                    <Col m={6}
                                         s={6}>
                                    <Select
                                        label="Choose your option"
                                        options={{
                                            classes: '',
                                            dropdownOptions: {
                                                alignment: 'left',
                                                autoTrigger: true,
                                                closeOnClick: true,
                                                constrainWidth: true,
                                                container: null,
                                                coverTrigger: true,
                                                hover: false,
                                                inDuration: 150,
                                                onCloseEnd: null,
                                                onCloseStart: null,
                                                onOpenEnd: null,
                                                onOpenStart: null,
                                                outDuration: 250
                                            }
                                        }}
                                        value={this.state.selectedCourse}
                                        onChange={this.handleCourse.bind(this)}
                                    >
                                        <option value={this.state.coursesCanChoose}>
                                            {this.state.coursesCanChoose}
                                        </option>
                                    </Select>
                                    </Col>
                                </Row>

                            <Button onClick={saveCourse} >Choose this course</Button>
                                <hr style={{background: 'white'}}></hr>
                            <h1>Student Learning Course</h1>

                            <Row className="bottom-row">

                                <NormalTile
                                    image={"/brainprocess.jpg"}
                                    title={user.first_name + ' ' + user.surname}
                                    subtitle={'Take this quiz to get your results'}
                                    description={'It will help'}
                                    button={'TakeQuiz'}
                                />

                            </Row>
                        </div> : null

                    }

                </Container>
                }
            </div>
        )

    }
}




const mapStateToProps = state => ({
    auth: state.auth
});

export default connect(
    mapStateToProps,
    null
)(Entry);