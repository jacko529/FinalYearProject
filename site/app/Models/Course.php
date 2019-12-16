<?php


namespace App\Models;


use App\Models\Connector\Neo4J;

class Course
{
    use Neo4J;

    public function insert($course, $user){
       $client = $this->connect();
       $client->run('MATCH (u:User {surname: "'.$user.'"})
            CREATE ('.$course.':Course 
            { name: "'.$course.'"})
             - [by: CREATE_BY] ->
              (u) RETURN u, '.$course.'');
       return ('done');
    }


    public function update($course, $field, $value){
        $this->client = $this->connect();
        $this->client->run('MATCH ('. $course .':Course {'.$course.'})
            SET '.$course.'.'.$field.' = '.$value.')');
    }

    public function delete($course){
        $client = $this->connect();
        $this->$client->run('MATCH ('. $course .':Course) (  name: '.$course.')
                            DELETE '. $course. '');
    }

    public function read(){}


}
