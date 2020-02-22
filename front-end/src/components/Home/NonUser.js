import React, { Component, Fragment } from 'react';
import {
    Collapse,
    Navbar,
    NavbarToggler,
    NavbarBrand,
    Nav,
    NavItem,
    ListGroup,
    ListGroupItem,
    ListGroupItemHeading,
    Container, NavLink
} from 'reactstrap';
import '../../Loader.css';
import '../../SidePanel.css';
import './Tiles'
import Tiles from "./Tiles";
import LoginModal from "../auth/LoginModel";
import RegisterModal from "../auth/RegisterModel";
import { connect } from 'react-redux';
import PropTypes from 'prop-types';


export class NonUser extends Component {

    static propTypes = {
        auth: PropTypes.object.isRequired
    };
    render() {
        console.log(this.props.auth);




        const welcome = (
            <Fragment>
                <Container>
                    <h1 style={{textAlign: "center"}}>Welcome to easy learning</h1>
                    <h2> Please log in</h2>
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