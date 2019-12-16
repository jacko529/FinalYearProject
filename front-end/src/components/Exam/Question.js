import React from 'react';
import PropTypes from 'prop-types';


function Question(props) {
    return (
        <h2 className="question">{props.content}</h2>
    );
    
}

Question.prototype = {
    content: PropTypes.string.isRequired
};

export default Question;