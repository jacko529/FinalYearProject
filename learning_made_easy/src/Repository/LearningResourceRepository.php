<?php


namespace App\Repository;


use GraphAware\Neo4j\Client\ClientInterface;


class LearningResourceRepository
{

    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
    public function connectWithPreviousLearningResource($nameOfCurrent, $nameOfPrevious, $timeBetween){

        $this->client->run(
            "MATCH (a:LearningResource),(b:LearningResource)
                   WHERE a.name_of_resource = '".$nameOfPrevious."' AND b.name_of_resource = '".$nameOfCurrent."'
                   CREATE (a)-[a:TimeDifficulty { time: '".$timeBetween."' }]->(b)"
        );
    }
    public function connectWithFirstLearningResource( $timeBetween, $course, $nameOfResource){

        $this->client->run(
            "MATCH (a:LearningResource),(b:Course)
                   WHERE a.name_of_resource = '".$nameOfResource."' AND b.name = '".$course."'
                   CREATE (b)-[cb:BELONGS_TO]->(a)
                   CREATE (b)-[r:TimeDifficulty { time: '".$timeBetween."' }]->(a)"
        );
    }



    public function matchFirst($learningType){

        return   $this->client->run(
           "MATCH (first:LearningResource)
                    WHERE first.learning_type = 'third' and first.stage = '1'
                    RETURN first");

    }

    public function connectUserAndLo($nameOfResource, $email){
        return $this->client->run(
            "MATCH (a:User { email: '$email' }),
            MATCH (b:LearningResource { name_of_resource: '$nameOfResource' })
            MERGE(a)-[r:Consumed]->(b)"

        );
    }


}