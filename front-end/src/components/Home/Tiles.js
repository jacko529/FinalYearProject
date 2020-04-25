import React, {Fragment} from 'react';
import {Button, Card, CardTitle, Icon} from 'react-materialize';

import '../../SidePanel.css';

import {Link} from "react-router-dom";

const Tiles = (props) => {
    let save = (e) => {
        e.preventDefault();
        console.log(props.learning_styles);
    };

    return (


        <Card
            actions={[
                <Button onClick={save}><Link to="/quiz">{props.button}</Link></Button>

            ]}
            header={<CardTitle image={props.image}>{props.title}</CardTitle>}
            revealicon={<Icon>more_vert</Icon>}

        >

            {props.subtitle}<br></br>
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdf'}>{props.learning_styles.global ?
                <Fragment> Global - {props.learning_styles.global} </Fragment> :
                <Fragment> Sequential - {props.learning_styles.sequential}</Fragment>}</a><br></br>
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdfl'}>{props.learning_styles.intuitive ?
                <Fragment> Intuitive - {props.learning_styles.intuitive} </Fragment> :
                <Fragment> Sensing - {props.learning_styles.sensing} </Fragment>} </a><br></br>
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdf'}>{props.learning_styles.reflective ?
                <Fragment> Reflective - {props.learning_styles.reflective}</Fragment> :
                <Fragment> Active - {props.learning_styles.active}</Fragment>}</a><br></br>
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdf'}>{props.learning_styles.verbal ?
                <Fragment> Verbal - {props.learning_styles.verbal} </Fragment> :
                <Fragment>Visual - {props.learning_styles.visual} </Fragment>}</a><br></br>
        </Card>


    );
};

export default Tiles;