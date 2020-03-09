<?php


require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;

class CreateUsers
{

    protected $client;
    protected $firstName;
    protected $lastname;
    protected $email;
    protected $password;
    protected $roles;
    protected $time;
    protected $learningStyle;
    protected $global;
    protected $intuitive;
    protected $reflector;
    protected $verbal;
    protected $course;


    public function __construct($firstName, $lastname, $email, $password, $time, $roles)
    {

        $this->client = ClientBuilder::create()
            ->addConnection('default', 'http://neo4j:jack@localhost:7474') // Example for HTTP connection configuration (port is optional)
            ->addConnection('bolt', 'bolt://neo4j:jack@localhost:7687') // Example for BOLT connection configuration (port is optional)
            ->build();
        $faker = \Faker\Factory::create();

        $this->firstName = $firstName;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->time = $time;
        $this->roles = $roles;
//        $this->verbal = $faker->numberBetween(1, 7);
//        $this->reflector = $faker->numberBetween(1, 8);
//        $this->global = $faker->numberBetween(0, 8);
//        $this->intuitive = $faker->numberBetween(0, 8);
//        $this->course = 'networking';

    }

    public function run($query){
        return $result = $this->client->run($query);
    }

    public function createUser(){
        $this->run("CREATE (n:User {firstName: '$this->firstName', surname: '$this->lastname', email: '$this->email',  password: '$this->password', roles: '$this->roles', time: '$this->time'})");
    }

    public function learningStyle(){
            $this->run("CREATE (learn: LearningStyle { global: '$this->global', intuitive: '$this->intuitive',   reflector: '$this->reflector', verbal: '$this->verbal' })
                           WITH learn
                           MATCH (a:User { email: '$this->email' })
                           CREATE (a)-[:HAS]->(learn)");
    }

    public function addConstraint(){
        $this->run("CREATE CONSTRAINT learning_resource
                        ON (n:LearningResource)
                        ASSERT n.email IS UNIQUE");
    }

    public function connectCourse(){
        $this->run("MATCH (a:User { email: '$this->email' })
                     MATCH (n:Course { name: '$this->course' })
                     MERGE(a)-[r:STUDYING]->(n)");
    }
    public function flush(){
    }

}