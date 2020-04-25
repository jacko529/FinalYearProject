import React from 'react';
import ReactDOM from 'react-dom';
// import {RadioGroup, Radio} from 'react-radio-group';
import {Radio, RadioGroup} from 'react-radio-group';

import '../../SidePanel.css';
import axios from 'axios';
import {Button, Col, Container, Row,} from 'react-materialize';

class MasterForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currentStep: 1,
            error: '',
            q1: '',
            q2: '',
            q3: '',
            q4: '',
            q5: '',
            q6: '',
            q7: '',
            q8: '',
            q9: '',
            q10: '',
            q11: '',
            q12: '',
            q13: '',
            q14: '',
            q15: '',
            q16: '',
            q17: '',
            q18: '',
            q19: '',
            q20: '',
            q21: '',
            q22: '',
            q23: '',
            q24: '',
            q25: '',
            q26: '',
            q27: '',
            q28: '',
            q29: '',
            q30: '',
            q31: '',
            q32: '',
            q33: '',
            q34: '',
            q35: '',
            q36: '',
            q37: '',
            q38: '',
            q39: '',
            q40: '',
            q41: '',
            q42: '',
            q43: '',
            q44: ''
        }
    }


    handleChange = event => {
        const {name, value} = event.target;
        this.setState({
            [name]: value
        });

    };


    changeQ1 = (value) => {
        this.setState({q1: value});
    };
    changeQ2 = (value) => {
        this.setState({q2: value});
    };
    changeQ3 = (value) => {
        this.setState({q3: value});
    };
    changeQ4 = (value) => {
        this.setState({q4: value});
    };
    changeQ5 = (value) => {
        this.setState({q5: value});
    };
    changeQ6 = (value) => {
        this.setState({q6: value});
    };
    changeQ7 = (value) => {
        this.setState({q7: value});
    };
    changeQ8 = (value) => {
        this.setState({q8: value});
    };
    changeQ9 = (value) => {
        this.setState({q9: value});
    };
    changeQ10 = (value) => {
        this.setState({q10: value});
    };
    changeQ11 = (value) => {
        this.setState({q11: value});
    };
    changeQ12 = (value) => {
        this.setState({q12: value});
    };
    changeQ13 = (value) => {
        this.setState({q13: value});
    };
    changeQ14 = (value) => {
        this.setState({q14: value});
    };
    changeQ15 = (value) => {
        this.setState({q15: value});
    };
    changeQ16 = (value) => {
        this.setState({q16: value});
    };
    changeQ17 = (value) => {
        this.setState({q17: value});
    };
    changeQ18 = (value) => {
        this.setState({q18: value});
    };
    changeQ19 = (value) => {
        this.setState({q19: value});
    };
    changeQ20 = (value) => {
        this.setState({q20: value});
    };
    changeQ21 = (value) => {
        this.setState({q21: value});
    };
    changeQ22 = (value) => {
        this.setState({q22: value});
    };
    changeQ23 = (value) => {
        this.setState({q23: value});
    };
    changeQ24 = (value) => {
        this.setState({q24: value});
    };
    changeQ25 = (value) => {
        this.setState({q25: value});
    };
    changeQ26 = (value) => {
        this.setState({q26: value});
    };
    changeQ27 = (value) => {
        this.setState({q27: value});
    };
    changeQ28 = (value) => {
        this.setState({q28: value});
    };
    changeQ29 = (value) => {
        this.setState({q29: value});
    };
    changeQ30 = (value) => {
        this.setState({q30: value});
    };
    changeQ31 = (value) => {
        this.setState({q31: value});
    };
    changeQ32 = (value) => {
        this.setState({q32: value});
    };
    changeQ33 = (value) => {
        this.setState({q33: value});
    };
    changeQ34 = (value) => {
        this.setState({q34: value});
    };
    changeQ35 = (value) => {
        this.setState({q35: value});
    };
    changeQ36 = (value) => {
        this.setState({q36: value});
    };
    changeQ37 = (value) => {
        this.setState({q37: value});
    };
    changeQ38 = (value) => {
        this.setState({q38: value});
    };
    changeQ39 = (value) => {
        this.setState({q39: value});
    };
    changeQ40 = (value) => {
        this.setState({q40: value});
    };
    changeQ41 = (value) => {
        this.setState({q41: value});
    };
    changeQ42 = (value) => {
        this.setState({q42: value});
    };
    changeQ43 = (value) => {
        this.setState({q43: value});
    };
    changeQ44 = (value) => {
        this.setState({q44: value});
    };


    handleSubmit = event => {
        event.preventDefault();
        let arrays = this.state;
        delete arrays.currentStep;
        const token = {
            headers: {Authorization: `Bearer ${localStorage.getItem('access_token')}`}
        };
        axios.post("/learning-style", this.state, token).then(response => {
            window.location.href = '/me';
        }).catch(error => {
            this.setState({
                currentStep: 1
            });
            this.setState({
                error: 'You did not finish the quiz'
            })
        });
    };

    _next = () => {
        let currentStep = this.state.currentStep;
        currentStep = currentStep >= 3 ? 4 : currentStep + 1;
        this.setState({
            currentStep: currentStep
        })
    };

    _prev = () => {
        let currentStep = this.state.currentStep;
        currentStep = currentStep <= 1 ? 1 : currentStep - 1;
        this.setState({
            currentStep: currentStep
        })
    };

    /*
    * the functions for our button
    */
    previousButton() {
        let currentStep = this.state.currentStep;
        if (currentStep !== 1) {
            return (

                <Button
                    color={'btn-secondary'}
                    className={'float-left'}
                    onClick={this._prev}>
                    Previous
                </Button>
            )
        }
        return null;
    }

    nextButton() {
        let currentStep = this.state.currentStep;
        if (currentStep < 4) {
            return (
                <Button
                    color={'primary'}
                    className={'float-right'}
                    onClick={this._next}>
                    Next
                </Button>
            )
        }
        return null;
    }

    render() {

        return (
            <React.Fragment>
                <h3 style={{textAlign: 'center'}}> {this.state.error} </h3>
                <p style={{textAlign: 'center'}}>Step {this.state.currentStep} </p>


                {/*
        render the form steps and pass required props in
      */}

                <Step1
                    currentStep={this.state.currentStep}
                    handleChange={this.handleChange}
                    one={this.state.q1}
                    two={this.state.q2}
                    three={this.state.q3}
                    four={this.state.q4}
                    five={this.state.q5}
                    six={this.state.q6}
                    seven={this.state.q7}
                    eight={this.state.q8}
                    nine={this.state.q9}
                    ten={this.state.q10}
                    eleven={this.state.q11}
                    q1change={this.changeQ1}
                    q2change={this.changeQ2}
                    q3change={this.changeQ3}
                    q4change={this.changeQ4}
                    q5change={this.changeQ5}
                    q6change={this.changeQ6}
                    q7change={this.changeQ7}
                    q8change={this.changeQ8}
                    q9change={this.changeQ9}
                    q10change={this.changeQ10}
                    q11change={this.changeQ11}
                />
                <Step2
                    currentStep={this.state.currentStep}
                    handleChange={this.handleChange}
                    state12={this.state.q12}
                    state13={this.state.q13}
                    state14={this.state.q14}
                    state15={this.state.q15}
                    state16={this.state.q16}
                    state17={this.state.q17}
                    state18={this.state.q18}
                    state19={this.state.q19}
                    state20={this.state.q20}
                    state21={this.state.q21}
                    state22={this.state.q22}
                    q12change={this.changeQ12}
                    q13change={this.changeQ13}
                    q14change={this.changeQ14}
                    q15change={this.changeQ15}
                    q16change={this.changeQ16}
                    q17change={this.changeQ17}
                    q18change={this.changeQ18}
                    q19change={this.changeQ19}
                    q20change={this.changeQ20}
                    q21change={this.changeQ21}
                    q22change={this.changeQ22}
                />
                <Step3
                    currentStep={this.state.currentStep}
                    handleChange={this.handleChange}
                    state23={this.state.q23}
                    state24={this.state.q24}
                    state25={this.state.q25}
                    state26={this.state.q26}
                    state27={this.state.q27}
                    state28={this.state.q28}
                    state29={this.state.q29}
                    state30={this.state.q30}
                    state31={this.state.q31}
                    state32={this.state.q32}
                    state33={this.state.q33}
                    q23change={this.changeQ23}
                    q24change={this.changeQ24}
                    q25change={this.changeQ25}
                    q26change={this.changeQ26}
                    q27change={this.changeQ27}
                    q28change={this.changeQ28}
                    q29change={this.changeQ29}
                    q30change={this.changeQ30}
                    q31change={this.changeQ31}
                    q32change={this.changeQ32}
                    q33change={this.changeQ33}
                />

                <Step4
                    currentStep={this.state.currentStep}
                    handleChange={this.handleChange}
                    state34={this.state.q34}
                    state35={this.state.q35}
                    state36={this.state.q36}
                    state37={this.state.q37}
                    state38={this.state.q38}
                    state39={this.state.q39}
                    state40={this.state.q40}
                    state41={this.state.q41}
                    state42={this.state.q42}
                    state43={this.state.q43}
                    state44={this.state.q44}
                    q34change={this.changeQ34}
                    q35change={this.changeQ35}
                    q36change={this.changeQ36}
                    q37change={this.changeQ37}
                    q38change={this.changeQ38}
                    q39change={this.changeQ39}
                    q40change={this.changeQ40}
                    q41change={this.changeQ41}
                    q42change={this.changeQ42}
                    q43change={this.changeQ43}
                    q44change={this.changeQ44}
                    buttonSubmit={this.handleSubmit}

                />

                <div className="bg-info clearfix" style={{padding: '.5rem'}}>
                    {this.previousButton()}
                    {this.nextButton()}
                </div>


            </React.Fragment>
        );
    }
}

function Step1(props) {
    if (props.currentStep !== 1) {
        return null
    }
    return (
        <div className="multi-step">
            <Container>
                <Row>
                    <Col sm={{size: '12'}} md={{size: '6', offset: '3'}}>
                        <h2 className={'questionLegend'}>Learning Styles Quiz</h2>
                        <RadioGroup
                            name="q1"
                            selectedValue={props.one}
                            onChange={props.q1change}>
                            <legend className={'questionLegend'}>I understand something better after I</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Try it out.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Think it through.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q2"
                            selectedValue={props.two}
                            onChange={props.q2change}>
                            <legend className={'questionLegend'}>I would rather be considered</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Realistic.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Innovative.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q3"
                            selectedValue={props.three}
                            onChange={props.q3change}>
                            <legend className={'questionLegend'}>When I think about what I did yesterday, I am most
                                likely to get
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>A picture.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Words.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q4"
                            selectedValue={props.four}
                            onChange={props.q4change}>
                            <legend className={'questionLegend'}>I tend to.</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Understand details of a subject but may be fuzzy about its overall
                                structure.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Understand the overall structure but may be fuzzy about details.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q5"
                            selectedValue={props.five}
                            onChange={props.q5change}>
                            <legend className={'questionLegend'}>When I am learning something new, it helps me to.
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Talk about it.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Think about it.
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q6"
                            selectedValue={props.six}
                            onChange={props.q6change}>
                            <legend className={'questionLegend'}>If I were a teacher, I would rather teach a course.
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> That deals with facts and real life situations.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> That deals with ideas and theories.
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q7"
                            selectedValue={props.seven}
                            onChange={props.q7change}>
                            <legend className={'questionLegend'}>I prefer to get new information in</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Pictures, diagrams, graphs, or maps.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> Written directions or verbal information.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q8"
                            selectedValue={props.eight}
                            onChange={props.q8change}>
                            <legend className={'questionLegend'}>Once I understand</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> All the parts, I understand the whole thing.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>The whole thing, I see how the parts fit.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q9"
                            selectedValue={props.nine}
                            onChange={props.q9change}>
                            <legend className={'questionLegend'}>In a study group working on difficult material, I am
                                more likely to
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> jump in and contribute ideas.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>sit back and listen.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q10"
                            selectedValue={props.ten}
                            onChange={props.q10change}>
                            <legend className={'questionLegend'}>I find it easier.</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>To learn facts.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>To learn concepts.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q11"
                            selectedValue={props.eleven}
                            onChange={props.q11change}>
                            <legend className={'questionLegend'}>In a book with lots of pictures and charts, I am likely
                                to
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Look over the pictures and charts carefully.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Focus on the written text.
                            </label>
                        </RadioGroup>

                    </Col>
                </Row>
            </Container>
        </div>
    );
}

function Step2(props) {
    if (props.currentStep !== 2) {
        return null
    }
    return (
        <Container>
            <Row>
                <Col sm={{size: '12'}} md={{size: '6', offset: '3'}}>
                    <RadioGroup
                        name="q12"
                        selectedValue={props.state12}
                        onChange={props.q12change}>
                        <legend className={'questionLegend'}>When I solve maths problems</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/> I usually work my way to the solutions one step at a time.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/> I often just see the solutions but then have to struggle to figure out
                            the steps to
                            get to them.
                        </label>
                    </RadioGroup>


                    <RadioGroup
                        name="q13"
                        selectedValue={props.state13}
                        onChange={props.q13change}>
                        <legend className={'questionLegend'}>In classes I have taken</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>I have usually got to know many of the students.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>I have rarely got to know many of the students.
                        </label>
                    </RadioGroup>

                    <RadioGroup
                        name="q14"
                        selectedValue={props.state14}
                        onChange={props.q14change}>
                        <legend className={'questionLegend'}>In reading non-fiction, I prefer</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>Something that teaches me new facts or tells me how to do something.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>Something that gives me new ideas to think about.
                        </label>
                    </RadioGroup>

                    <RadioGroup
                        name="q15"
                        selectedValue={props.state15}
                        onChange={props.q15change}>
                        <legend className={'questionLegend'}>I like teachers</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>Who put a lot of diagrams on the board.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>Who spend a lot of time explaining.
                        </label>
                    </RadioGroup>

                    <RadioGroup
                        name="q16"
                        selectedValue={props.state16}
                        onChange={props.q16change}>
                        <legend className={'questionLegend'}>When I'm analysing a story or a novel</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/> I think of the incidents and try to put them together to figure out the
                            themes
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/> I just know what the themes are when I finish reading and then I have to
                            go back
                            and find the incidents that demonstrate them.
                        </label>
                    </RadioGroup>


                    <RadioGroup
                        name="q17"
                        selectedValue={props.state17}
                        onChange={props.q17change}>
                        <legend className={'questionLegend'}>When I start a homework problem, I am more likely to
                        </legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>Start working on the solution immediately.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>Try to fully understand the problem first.
                        </label>
                    </RadioGroup>


                    <RadioGroup
                        name="q18"
                        selectedValue={props.state18}
                        onChange={props.q18change}>
                        <legend className={'questionLegend'}>I prefer the idea of</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>Certainty.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>Theory
                        </label>
                    </RadioGroup>

                    <RadioGroup
                        name="q19"
                        selectedValue={props.state19}
                        onChange={props.q19change}>
                        <legend className={'questionLegend'}>I remember best</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>What I see.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>What I hear.
                        </label>
                    </RadioGroup>

                    <RadioGroup
                        name="q20"
                        selectedValue={props.state20}
                        onChange={props.q20change}>
                        <legend className={'questionLegend'}>It is more important to me that an instructor</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>Lay out the material in clear sequential steps
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>Give me an overall picture and relate the material to other subjects.
                        </label>
                    </RadioGroup>

                    <RadioGroup
                        name="q21"
                        selectedValue={props.state21}
                        onChange={props.q21change}>
                        <legend className={'questionLegend'}>I prefer to study</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>In a group.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>Alone.
                        </label>
                    </RadioGroup>

                    <RadioGroup
                        name="q22"
                        selectedValue={props.state22}
                        onChange={props.q22change}>
                        <legend className={'questionLegend'}>I am more likely to be considered.</legend>
                        <label className={'questionLabel'}>
                            <Radio value="a"/>Careful about the details of my work.
                        </label>
                        <label className={'questionLabel'}>
                            <Radio value="b"/>Creative about how to do my work.
                        </label>
                    </RadioGroup>

                </Col>
            </Row>
        </Container>
    );
}


function Step3(props) {
    if (props.currentStep !== 3) {
        return null
    }
    return (
        <React.Fragment>
            <Container>
                <Row>
                    <Col sm={{size: '12'}} md={{size: '6', offset: '3'}}>
                        <RadioGroup
                            name="q23"
                            selectedValue={props.state23}
                            onChange={props.q23change}>
                            <legend className={'questionLegend'}>When I get directions to a new place, I prefer</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>A map.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Written instructions.
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q24"
                            selectedValue={props.state24}
                            onChange={props.q24change}>
                            <legend className={'questionLegend'}>I learn</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>At a fairly regular pace. If I study hard, I'll "get it."
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>In fits and starts. I'll be totally confused and then suddenly it all
                                "clicks."
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q25"
                            selectedValue={props.state25}
                            onChange={props.q25change}>
                            <legend className={'questionLegend'}>I would rather first</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Try things out.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Think about how I'm going to do it
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q26"
                            selectedValue={props.state26}
                            onChange={props.q26change}>
                            <legend className={'questionLegend'}>When I am reading for enjoyment, I like writers to
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Clearly say what they mean.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Say things in creative, interesting ways.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q27"
                            selectedValue={props.state27}
                            onChange={props.q27change}>
                            <legend className={'questionLegend'}>When I see a diagram or sketch in class, I am most
                                likely to remember
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> The picture.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> What the instructor said about it.
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q28"
                            selectedValue={props.state28}
                            onChange={props.q28change}>
                            <legend className={'questionLegend'}>When considering a body of information, I am more
                                likely to
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Focus on details and miss the big picture.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Try to understand the big picture before getting into the details.
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q29"
                            selectedValue={props.state29}
                            onChange={props.q29change}>
                            <legend className={'questionLegend'}>I more easily remember</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Something I have done.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Something I have thought a lot about.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q30"
                            selectedValue={props.state30}
                            onChange={props.q30change}>
                            <legend className={'questionLegend'}>When I have to perform a task, I prefer to</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>master one way of doing it.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>come up with new ways of doing it.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q31"
                            selectedValue={props.state31}
                            onChange={props.q31change}>
                            <legend className={'questionLegend'}>When someone is showing me data, I prefer</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>charts or graphs.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> text summarizing the results.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q32"
                            selectedValue={props.state32}
                            onChange={props.q32change}>
                            <legend className={'questionLegend'}>When writing a paper, I am more likely to</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Work on (think about or write) the beginning of the paper and progress
                                forward.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Work on (think about or write) different parts of the paper and then
                                order them.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q33"
                            selectedValue={props.state33}
                            onChange={props.q33change}>
                            <legend className={'questionLegend'}>.When I have to work on a group project, I first want
                                to
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Have a "group brainstorming" where everyone contributes ideas.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Brainstorm individually and then come together as a group to compare
                                ideas.
                            </label>
                        </RadioGroup>

                    </Col>
                </Row>
            </Container>

        </React.Fragment>
    );
}


function Step4(props) {
    if (props.currentStep !== 4) {
        return null
    }
    return (
        <React.Fragment>
            <Container>
                <Row>
                    <Col sm={{size: '12'}} md={{size: '6', offset: '3'}}>
                        <RadioGroup
                            name="q34"
                            selectedValue={props.state34}
                            onChange={props.q34change}>
                            <legend className={'questionLegend'}>I consider it higher praise to call someone</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Sensible.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> Imaginative.
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q35"
                            selectedValue={props.state35}
                            onChange={props.q35change}>
                            <legend className={'questionLegend'}>When I meet people at a party, I am more likely to
                                remember
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>What they looked like.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>What they said about themselves.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q36"
                            selectedValue={props.state36}
                            onChange={props.q36change}>
                            <legend className={'questionLegend'}>When I am learning a new subject, I prefer to</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Stay focused on that subject, learning as much about it as I can.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> Try to make connections between that subject and related subjects.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q37"
                            selectedValue={props.state37}
                            onChange={props.q37change}>
                            <legend className={'questionLegend'}>I am more likely to be considered</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Outgoing.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Reserved.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q38"
                            selectedValue={props.state38}
                            onChange={props.q38change}>
                            <legend className={'questionLegend'}>I prefer courses that emphasise</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Concrete material (facts, data).
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Abstract material (concepts, theories).
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q39"
                            selectedValue={props.state39}
                            onChange={props.q39change}>
                            <legend className={'questionLegend'}>For entertainment, I would rather</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Watch television.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Read a book.
                            </label>
                        </RadioGroup>


                        <RadioGroup
                            name="q40"
                            selectedValue={props.state40}
                            onChange={props.q40change}>
                            <legend className={'questionLegend'}>Some teachers start their lectures with an outline of
                                what they will cover. Such
                                outlines are
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Somewhat helpful to me.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Very helpful to me.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q41"
                            selectedValue={props.state41}
                            onChange={props.q41change}>
                            <legend className={'questionLegend'}>The idea of doing homework in groups, with one grade
                                for the entire group,
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/>Appeals to me.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/>Does not appeal to me.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q42"
                            selectedValue={props.state42}
                            onChange={props.q42change}>
                            <legend className={'questionLegend'}>When I am doing long calculations,</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> I tend to repeat all my steps and check my work carefully.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> I find checking my work tiresome and have to force myself to do it.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q43"
                            selectedValue={props.state43}
                            onChange={props.q43change}>
                            <legend className={'questionLegend'}>I tend to picture places I have been</legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Easily and fairly accurately.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> With difficulty and without much detail.
                            </label>
                        </RadioGroup>

                        <RadioGroup
                            name="q44"
                            selectedValue={props.state44}
                            onChange={props.q44change}>
                            <legend className={'questionLegend'}>When solving problems in a group, I would be more
                                likely to
                            </legend>
                            <label className={'questionLabel'}>
                                <Radio value="a"/> Think of the steps in the solution process.
                            </label>
                            <label className={'questionLabel'}>
                                <Radio value="b"/> Think of possible consequences or applications of the solution in a
                                wide range of
                                areas.
                            </label>
                        </RadioGroup>

                    </Col>

                </Row>
                <Button style={{textAlign: 'center'}} onClick={props.buttonSubmit}>Submit Quiz</Button>


            </Container>

        </React.Fragment>
    );
}


ReactDOM.render(<MasterForm/>, document.getElementById('root'));
export default MasterForm;