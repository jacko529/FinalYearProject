<?php


namespace App\Repository;


use Aws\S3\S3Client;
use GraphAware\Neo4j\Client\ClientInterface;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LearningResourceRepository
{

    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
    public function createRelationship($nameOfCurrent, $nameOfPrevious, $timeBetween){

        $this->client->run(
            "MATCH (a:LearningResource),(b:LearningResource)
                   WHERE a.name_of_resource = '".$nameOfPrevious."' AND b.name_of_resource = '".$nameOfCurrent."'
                   CREATE (a)-[r:TimeDifficulty { time: '".$timeBetween."' }]->(b)"
        );
    }

    public function matchFirst($learningType){

       $learning =   $this->client->run(
           "MATCH (first:LearningResource)
                    WHERE first.learning_type = 'third' and first.stage = '1'
                    RETURN first");
       return $learning;

    }

    public function connectUserAndLo($nameOfResource, $email){
        return $this->client->run(
            "MATCH (a:User),(b:LearningResource)
                    WHERE a.email= '".$email."' and b.name_of_resource = '".$nameOfResource."'
                    CREATE (a)-[r:Consumed]->(b)"
        );
    }
}