<?php

require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;


class MatchUser
{


    protected $client;
    protected $number;



    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->addConnection(
                'default',
                'http://neo4j:jack@localhost:7474'
            ) // Example for HTTP connection configuration (port is optional)
            ->addConnection(
                'bolt',
                'bolt://neo4j:jack@localhost:7687'
            ) // Example for BOLT connection configuration (port is optional)
            ->build();
        $faker = \Faker\Factory::create();
        $this->number = $faker->numberBetween(0, 8);

    }

// if stage is 4 then consume the 3 previous
    public function match($email){
        $resource1 =[
            "verbal"	,
            "intuitive"	,
            "global"	,
            "reflective"	,
        ];

        $randIndex = array_rand($resource1);

        $this->client->run("MATCH (a:User { email: '$email' })
                  MATCH (first:LearningResource {stage: '8', learning_type : '$resource1[$randIndex]'})
                 MERGE(a)-[r:Consumed]->(first)
                 return first");

    }

    public function checkStage($name){
       return $this->client->run("
                  MATCH (first:LearningResource {name_of_resource: '$name'})
                 return first.stage as stage");
    }
}