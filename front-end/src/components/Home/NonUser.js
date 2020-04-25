import React, {Component, Fragment} from 'react';
import {Container,} from 'react-materialize';
import '../../Loader.css';
import '../../SidePanel.css';
import './Tiles'
import Tiles from "./Tiles";

import {connect} from 'react-redux';


export class NonUser extends Component {


    render() {


        const welcome = (
            <Fragment>
                <Container style={{textAlign: "center"}}>
                    <h1 style={{marginBottom: "7rem", marginTop: '4rem', color: 'white'}}>Welcome to Easy Learn</h1>
                    <h2 style={{color: 'white'}}> It might just be easier to study </h2>
                    <h3 style={{color: 'white'}}> Please Login</h3>
                </Container>
            </Fragment>
        );

        return (
            <div>
                {welcome}
            </div>

        );
    }
}


const mapStateToProps = state => ({
    auth: state.auth
});

export default connect(
    mapStateToProps,
    null
)(Tiles);