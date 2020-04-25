import React from 'react';

import {Card, CardTitle, Col, Icon} from 'react-materialize';
import 'materialize-css'
import '../../SidePanel.css';


const NoCourseTile = (props) => {
    let save = (e) => {
        e.preventDefault();
    };
    console.log('tile', props.url);
    return (

        <Col m={2}
             s={6}>
            <Card
                actions={[]}
                header={<CardTitle image={props.image}>{props.title}</CardTitle>}
                revealicon={<Icon>more_vert</Icon>}

            >

                There is no similar user items presently
            </Card>


        </Col>

    );
};

export default NoCourseTile;