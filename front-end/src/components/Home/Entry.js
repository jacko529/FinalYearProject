import React, {Component, Fragment} from 'react';
import {Button, Container, Select, Collection, Range, CollectionItem, Row, Col} from 'react-materialize';
import 'materialize-css'
import '../../Loader.css';
import '../../SidePanel.css';
import './Tiles'
import Tiles from "./Tiles";
import NormalTile from "./NormalTile";
import CourseTile from "./CourseTile";

import axios from 'axios';

import {connect} from 'react-redux';
import NoCourseTile from "./NoCourseTile";
import Loader from "react-loader-spinner";
import {Graph} from "react-d3-graph";


export class Entry extends Component {

    state = {
        requestCompleted: false,
        learning_styles: [],
        course: [],
        value: 10,
        url: '',
        rangeValue: '',
        explainShortPath: [],
        coursesCanChoose: [],
        selectedCourse: '',
        recommendation: [],
        noCourse: [],
        timeDisappear: false,
        completeDataSet: [],
        courseDisappear: false,


    };

    componentWillMount() {


        const config = {
            headers: {
                Authorization: `bearer ${localStorage.getItem('access_token')}`,
                'Content-type': 'application/json'
            }

        };

        axios.get('/next-active', config)
            .then(res => {
                // if it is the first course
                 this.setState({completeDataSet: res.data});
                 console.log(this.state.completeDataSet)

                if (!res.data['shortest_path'] && !res.data['jarrard'] && !res.data['none']) {
                    this.setState({course: res.data[0]});
                   // if there is nothing done yet (new user)
               }else if(res.data['none']){
                   this.setState({noCourse: res.data['none']});
               }else if (res.data['shortest_path'] && !res.data['jarrard']){
                   this.setState({course: res.data['shortest_path'][0]});
                   this.setState({explainShortPath: res.data['explain_short_path'][0]});

               } else {
                    console.log('request', res.data['explain_short_path'][0])
                    this.setState({course: res.data['shortest_path'][0]});
                    this.setState({recommendation: res.data['jarrard'][0]});
                    this.setState({explainShortPath: res.data['explain_short_path'][0]});

                }

                this.setState({requestCompleted: true});
            }).then(
            axios.get('/courses', config)
                .then(ress => {
                    this.setState({coursesCanChoose: ress.data.data});
                    this.setState({selectedCourse: ress.data.data[0]});

                })
        );

    }


    handleCourse(event) {
        this.setState({selectedCourse: event.target.value})

    }

    handleRangeSlider(event) {
        this.setState({rangeValue: event.target.value})
    }


    render() {


// the graph configuration, you only need to pass down properties
// that you want to override, otherwise default ones will be used

        const myConfig = {
            directed: true,

            nodeHighlightBehavior: true,
            node: {
                color: "lightblue",
                size: 420,
                symbolType: 'wye',
                fontColor: 'white',
                highlightStrokeColor: "blue",
            },
            link: {
                renderLabel: true,
                highlightColor: "blue",
                fontSize: 15,
                fontColor: 'white',
                semanticStrokeWidth: true,
                labelProperty: 'label'
            },
        };

        // graph event callbacks
        const onClickGraphFirst = function () {
        };

        const onClickNodeFirst = function (nodeId) {
        };

        const onDoubleClickNodeFirst = function (nodeId) {
        };

        const onRightClickNodeFirst = function (event, nodeId) {
        };

        const onMouseOverNodeFirst = function (nodeId) {
        };

        const onMouseOutNodeFirst = function (nodeId) {
        };

        const onClickLinkFirst = function (source, target) {
        };

        const onRightClickLinkFirst = function (event, source, target) {
        };

        const onMouseOverLinkFirst = function (source, target) {
        };

        const onMouseOutLinkFirst = function (source, target) {
        };

        const onNodePositionChangeFirst = function (nodeId, x, y) {
        };




        const {isTeacher, isUser, isLoading, isAuthenticated, user} = this.props.auth;
        // const {isTeacher,isUser, isLoading, isAuthenticated, user } = this.props.auth;


        let saveCourse = (e) => {
            const config = {
                headers: {
                    Authorization: `bearer ${localStorage.getItem('access_token')}`,
                    'Content-type': 'application/json'
                }
            };
            e.preventDefault();

            const body = JSON.stringify({course: this.state.selectedCourse});

            axios.post('/courses', body, config)
                .then(res => {
                    // console.log(res.data);
                    this.setState({courseDisappear: true});

                });
        }
        let save = (e) => {
            const config = {
                headers: {
                    Authorization: `bearer ${localStorage.getItem('access_token')}`,
                    'Content-type': 'application/json'
                }
            };
            e.preventDefault();
            const body = JSON.stringify({time: this.state.rangeValue});

            axios.post('/user-time', body, config)
                .then(res => {
                    this.setState({timeDisappear: true});
                });


        }

        const welcome = (
            <Fragment>
                <h1 style={{textAlign: "center", marginBottom: "2rem", marginTop: '4rem', color: 'white'}}>Welcome to
                    Easy Learn</h1>

                <Collection>
                    <CollectionItem>
                        First select a preference in course consumption time
                    </CollectionItem>
                    <CollectionItem>
                        Then select the a course
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


        const {value} = this.state
        if (this.state.requestCompleted) {
            // {this.explainShortPath.map((course) => console.log(course) )}
            console.log('recomm', this.state.selectedCourse)

        }
        const loadingSign = (
            <div className={this.state.requestCompleted ? 'normal' : 'loader  '} style={{textAlign: 'center'}}>
                <Loader
                    type="MutatingDots"
                    color="#00BFFF"
                    height={80}
                    width={80}
                    timeout={500} //3 secs
                />
            </div>
        );

        let timeClass = this.state.timeDisappear ? "timeDiv" : "";
        let courseClass = this.state.courseDisappear ? "courseDiv" : "";

        return (

            <div>

                {!this.state.requestCompleted ? loadingSign :
                    <Container>

                        {welcome}

                        {Object.keys(user.learning_styles).length > 1 ?
                        <div>
                        <h2>Other courses you can take</h2>
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

                            { this.state.coursesCanChoose.map((item, key) =>
                                <option value={item}>
                                    {item}
                                </option>
                            )}


                        </Select>
                        <div style={{textAlign:"center"}}>
                        <Button onClick={saveCourse}>Choose this course</Button>
                        </div>
                        </div>
                        : null}
                        <h2>Courses currently taking</h2>

                        { Object.values(this.state.completeDataSet).map((item, key) =>

                            <div>
                                {/*{console.log(item.resource.none)}*/}
                               <h3>{item.course}</h3>
                               <Row className="bottom-row">
                                   {/*<Bar  data={data} options={options} />*/}

                                   {item.resource ?
                                       <NoCourseTile
                                           image={"/study-notebooks.jpg"}
                                           title={item.resource.none}
                                       />
                                       :null}
                            {item.shortest_path ?
                               <CourseTile
                                   image={item.course_image}
                                   title={item.shortest_path.resource.name_of_resource}
                                   stage={item.shortest_path.resource.stage}
                                   course={item.course}
                                   time={item.shortest_path.resource.time}
                                   url={item.shortest_path.resource.url}
                                   email={user.email}
                                   button={'Start Course'}
                                   />
                                : null}
                                   {item.jarrard    ?

                                       <CourseTile
                                       image={"/study.jpg"}
                                       title={item.jarrard.resource.name_of_resource}
                                       stage={item.jarrard.resource.stage}
                                       course={item.course}
                                       time={item.jarrard.resource.time}
                                       url={item.jarrard.resource.url}
                                       email={user.email}
                                       button={'Start Course'}
                                       />

                                       : null}

                               </Row>
                                {item.explain_short_path ?
                               <Col>
                                   <h3>Explain your path </h3>
                                   <h4 style={{color: 'white'}}>This are the top  learning paths which are based
                                       around the time your spefifed at the beginning of the course</h4>
                                   <h5 style={{color: 'white'}}>You can look into your top learning paths by selecting
                                       the graph, these graphs where selected by finding the shortest path based around
                                       how long it takes to get from one resource to the next</h5>
                                   <Graph
                                       id="graph-id" // id is mandatory, if no id is defined rd3g will throw an error
                                       data={item.explain_short_path.first}
                                       config={myConfig}
                                       onClickNode={onClickNodeFirst}
                                       onDoubleClickNode={onDoubleClickNodeFirst}
                                       onRightClickNode={onRightClickNodeFirst}
                                       onClickGraph={onClickGraphFirst}
                                       onClickLink={onClickLinkFirst}
                                       onRightClickLink={onRightClickLinkFirst}
                                       onMouseOverNode={onMouseOverNodeFirst}
                                       onMouseOutNode={onMouseOutNodeFirst}
                                       onMouseOverLink={onMouseOverLinkFirst}
                                       onMouseOutLink={onMouseOutLinkFirst}
                                       onNodePositionChange={onNodePositionChangeFirst}
                                   />

                               </Col>
                                    :null}
                           </div>
                        )}




                        {Object.keys(user.learning_styles).length < 1 ?

                            <div className="bottom-row" style={{textAlign: 'center'}}>
                                <Row
                                style={{display:'block'}}>
                                    <h2>Student Learning Course</h2>
                                    <hr style={{background: 'white'}}></hr>

                                    <Col l={6}
                                         m={6}
                                         s={12}>

                                        <NormalTile
                                            image={"/brainprocess.jpg"}
                                            title={user.first_name + ' ' + user.surname}
                                            subtitle={'Take this quiz to get your results'}
                                            description={'It will help'}
                                            button={'TakeQuiz'}
                                        />
                                    </Col>

                                    <Col l={6}
                                         m={6}
                                         s={12} className={timeClass}  style={{marginBottom: '3rem'}}>

                                        <h2>Student Information</h2>
                                        <h4>First enter your time you want to spend on the course</h4>
                                        <Range
                                            value={this.state.rangeValue}
                                            onChange={this.handleRangeSlider.bind(this)}
                                            max="100"
                                            min="0"
                                            name="points"
                                        />
                                        {user.time === '' ? <Button onClick={save}>That's enough time</Button> : null}

                                    </Col>

                                    <Col l={6}
                                         m={6}
                                         s={12} className={courseClass}>

                                        <h4>Now select the course you wish to take</h4>

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

                                            { this.state.coursesCanChoose.map((item, key) =>
                                                <option key={key} value={item}>
                                                    {item}
                                                </option>
                                            )}

                                        </Select>
                                        <Button onClick={saveCourse}>Choose this course</Button>

                                    </Col>

                                </Row>
                            </div> : null




                        }
                        {Object.keys(user.learning_styles).length > 0 ?
                            <div>
                                <Row>
                            <Col sm={12} md={6} lg={6}>
                                <h3>Take the quiz again</h3>
                                <Tiles
                                    image={"/audo.jpg"}
                                    title={user.first_name + ' ' + user.surname}
                                    learning_styles={user.learning_styles}
                                    subtitle={'Here are your results'}
                                    description={'It will help'}
                                    button={'TakeQuiz'}
                                />
                            </Col>
                            <Col l={6}
                            m={6}
                            s={12} className={timeClass}  style={{marginBottom: '3rem'}}>
                            <h4>You can edit your overall time wanting to spend on a course</h4>
                            <Range
                            value={this.state.rangeValue}
                            onChange={this.handleRangeSlider.bind(this)}
                            max="100"
                            min="0"
                            name="points"
                            />
                          <Button onClick={save}>That's enough time</Button>

                            </Col>
                                </Row>
                            </div>

                            : null}

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