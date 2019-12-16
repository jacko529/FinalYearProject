<?php


namespace App\Models;

use Illuminate\Support\Facades\Hash;
use App\Models\Connector\Neo4J;

class User
{
    use Neo4J;

    //@to-do remove hash facade
    public function __construct()
    {


    }

    public function insert($firstName, $surname, $email, $password, $teacher){
        $client = $this->connect();
        $user = $client->run('CREATE ('. $surname .':User
                  {
                    first_name: "'.$firstName.'",
                    surname: "'. $surname .'",
                    email: "'. $email .'",
                    password: "'. Hash::make($password) .'",
                    teacher: "'. $teacher .'"
                   })
        RETURN '.$surname.'');

        return $user;
    }


    public function deleteUser($user)
    {
        $this->client = $this->connect();
        $this->client->run('MATCH (
                                '. $user .':User { surname: '. $user.' })
                                 DELETE '. $user. '');
        return ('done');
    }

    public function updateUser($user, $field, $value){
        $this->client = $this->connect();
        $this->client->run('MATCH ('. $user .':User {'.$user.'})
            SET '.$user.'.'.$field.' = '.$value.')');
    }

}
