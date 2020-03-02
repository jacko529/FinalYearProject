import React from 'react';
import { Button, Card, CardTitle,Icon, Row, Col } from 'react-materialize';

import '../../SidePanel.css';

import {
    Link
} from "react-router-dom";

const Tiles = (props) => {
    let save = (e) => {
        e.preventDefault();
        console.log('account');
    }

    return (

        <Col   m={2}
               s={6}>
            <Card
                actions={[
                    <Button  onClick={save}><Link to="/quiz">{props.button}</Link></Button>

                ]}
                header={<CardTitle image={props.image}>{props.title}</CardTitle>}
                revealicon={<Icon>more_vert</Icon>}

            >

                {props.subtitle}<br></br>
                Global - {props.learning_styles.global}<br></br>
                Intuitive - {props.learning_styles.intuitive}<br></br>
                reflector - {props.learning_styles.reflector}<br></br>
                Verbal - {props.learning_styles.verbal}<br></br>
            </Card>
        </Col>


    );
};

export default Tiles;