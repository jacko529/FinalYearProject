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
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdf'}>
              Global - {props.learning_styles.global} </a><br></br>
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdfl'}>
               Intuitive - {props.learning_styles.intuitive} </a><br></br>
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdf'}>
               Reflective - {props.learning_styles.reflective} </a><br></br>
            <a href={'http://dev.orgwise.ca/sites/osi.ocasi.org.stage/files/Felder%20and%20Silverman%27s%20Index%20of%20Learning%20Styles.pdf'}>
                Verbal - {props.learning_styles.verbal} </a><br></br>
        </Card>


    );
};

export default Tiles;