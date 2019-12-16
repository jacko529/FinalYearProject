import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';

class MasterForm extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            currentStep: 1,
            course:  '',
            username: '',
            password: '',
        }
    }

    handleChange = event => {
        const {name, value} = event.target
        this.setState({
            [name]: value
        })
    }

    handleSubmit = event => {
        event.preventDefault()
        const { course, username, password } = this.state
        alert(`Your registration detail: \n 
           course: ${course} \n 
           Username: ${username} \n
           Password: ${password}`)
    }

    _next = () => {
        let currentStep = this.state.currentStep
        currentStep = currentStep >= 2? 3: currentStep + 1
        this.setState({
            currentStep: currentStep
        })
    }

    _prev = () => {
        let currentStep = this.state.currentStep
        currentStep = currentStep <= 1? 1: currentStep - 1
        this.setState({
            currentStep: currentStep
        })
    }

    /*
    * the functions for our button
    */
    previousButton() {
        let currentStep = this.state.currentStep;
        if(currentStep !==1){
            return (
                <button
                    className="btn btn-secondary"
                    type="button" onClick={this._prev}>
                    Previous
                </button>
            )
        }
        return null;
    }

    nextButton(){
        let currentStep = this.state.currentStep;
        if(currentStep <3){
            return (
                <button
                    className="btn btn-primary float-right"
                    type="button" onClick={this._next}>
                    Next
                </button>
            )
        }
        return null;
    }

    render() {
        return (
            <React.Fragment>
                <p>Step {this.state.currentStep} </p>

                <form onSubmit={this.handleSubmit}>
                    {/*
        render the form steps and pass required props in
      */}
                    <Step1
                        currentStep={this.state.currentStep}
                        handleChange={this.handleChange}
                        course={this.state.course}
                    />
                    <Step2
                        currentStep={this.state.currentStep}
                        handleChange={this.handleChange}
                        username={this.state.username}
                    />
                    <Step3
                        currentStep={this.state.currentStep}
                        handleChange={this.handleChange}
                        password={this.state.password}
                    />
                    {this.previousButton()}
                    {this.nextButton()}

                </form>
            </React.Fragment>
        );
    }
}

function Step1(props) {
    if (props.currentStep !== 1) {
        return null
    }
    return(
        <div className="multi-step">
            <h1>Add A Course</h1>

            <label className="multi-step-label">course name</label>
            <input
                className="multi-step-input"
                type="text"
                placeholder="Enter course name"
                value={props.course}
                onChange={props.handleChange}
            />
            <label>Course length</label>
            <input
                className="multi-step-input"
                type="range"
                placeholder="Enter length"
                value={props.course}
                onChange={props.handleChange}
            />
            <label>Course tags</label>
            <select
                className="multi-step-input"
                placeholder="Enter length"
                value={props.course}
                onChange={props.handleChange}
            />
            <label>Course description</label>
            <textarea
                className="multi-step-input"
                placeholder="Enter description"
                value={props.course}
                onChange={props.handleChange}
            />
        </div>
    );
}

function Step2(props) {
    if (props.currentStep !== 2) {
        return null
    }
    return(
        <div className="form-group">
            <label htmlFor="username">Username</label>
            <input
                className="form-control"
                id="username"
                name="username"
                type="text"
                placeholder="Enter username"
                value={props.username}
                onChange={props.handleChange}
            />
        </div>
    );
}

function Step3(props) {
    if (props.currentStep !== 3) {
        return null
    }
    return(
        <React.Fragment>
            <div className="form-group">
                <label htmlFor="password">Password</label>
                <input
                    className="form-control"
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Enter password"
                    value={props.password}
                    onChange={props.handleChange}
                />
            </div>
            <button className="btn btn-success btn-block">Sign up</button>
        </React.Fragment>
    );
}

ReactDOM.render(<MasterForm />, document.getElementById('root'))
export default MasterForm;