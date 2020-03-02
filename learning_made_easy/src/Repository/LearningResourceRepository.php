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

    public function connectWithPreviousLearningResource($nameOfCurrent, $stage, $timeBetween)
    {
        $this->client->run(
            "MATCH (a:LearningResource),(b:LearningResource)
                   WHERE a.stage = '$stage' AND b.name_of_resource = '" . $nameOfCurrent . "'
                   CREATE (a)-[ti:TimeDifficulty { time: $timeBetween }]->(b)"
        );
    }

    public function connectWithFirstLearningResource($timeBetween, $course, $nameOfResource)
    {
        $this->client->run(
            "MATCH (a:LearningResource),(b:Course)
                   WHERE a.name_of_resource = '" . $nameOfResource . "' AND b.name = '" . $course . "'
                   CREATE (b)-[cb:BELONGS_TO]->(a)
                   CREATE (b)-[r:TimeDifficulty { time: $timeBetween }]->(a)"
        );
    }


    public function shortestPath($beginningStage, $stage, $learningType)
    {
        return $this->client->run(
            "match (start:LearningResource {name_of_resource: \"$beginningStage\"}), (end:LearningResource{stage: \"$stage\", learning_type: \"$learningType\"})
                    CALL algo.shortestPath.stream(start, end, \"time\") 
                    YIELD nodeId, cost
                    MATCH (LearningResource:LearningResource) WHERE id(LearningResource) = nodeId
                    RETURN LearningResource.name_of_resource AS name, cost "
        );
    }

    public function KshortestPath($beginningStage, $stage, $learningType){
        return $this->client->run(
            "match (start:LearningResource {name_of_resource: '$beginningStage'}), (end:LearningResource{stage: '$stage', learning_type: '$learningType'})
            CALL algo.kShortestPaths.stream(start, end, 3, 'time' ,{relationshipQuery:'TimeDifficulty'}) YIELD index, nodeIds, costs
            RETURN [node in algo.getNodesById(nodeIds) | node.name_of_resource] AS names,[node in algo.getNodesById(nodeIds) | node.learning_type] AS learning,costs,reduce(acc = 0.0, cost in costs | acc + cost) AS totalCost"
        );
    }


    public function jaradCollabortiveFiltering($email){
        return $this->client->run(
            "MATCH (p:User {email: \"$email\"})-[:SIMILAR]->(other),
            (other)-[:Consumed]->(LearningResource)
            WHERE not((p)-[:Consumed]->(LearningResource))
            RETURN LearningResource.name_of_resource as name , LearningResource.stage AS index"
        );
    }

    public function reRunMatchingProcess(){
        return $this->client->run(
        "MATCH (p:User)-[:Consumed]->(LearningResource)
        WITH {item:id(p), categories: collect(id(LearningResource))} as userData
        WITH collect(userData) as data
        CALL algo.similarity.jaccard(data, {topK: 1, similarityCutoff: 0.1, write:true})
        YIELD nodes, similarityPairs, write, writeRelationshipType, writeProperty, min, max, mean, stdDev, p25, p50, p75, p90, p95, p99, p999, p100
        RETURN nodes, similarityPairs, write, writeRelationshipType, writeProperty, min, max, mean, p95"
        );
    }


    public function deleteSimlarReltionships(){
        return $this->client->run(
            "match (:User)-[r:SIMILAR]->(:User) delete r"
        );
    }

    public function compareTotalCostWithTime($beginningStage, $stage, $learningType){
        return $this->client->run(
            "match (start:LearningResource {name_of_resource: \"$beginningStage\"}), (end:LearningResource{stage: \"$stage\", learning_type: \"$learningType\"})
                            CALL algo.shortestPath.stream(start, end, \"time\") 
                            YIELD  totalCost
                            RETURN totalCost "
        );
        }

    public function matchFirst($learningType, $email, $course){
        $firstMatchingRecord =  [];
         $learningRecords =    $this->client->run(
           "MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (first:LearningResource)
                  where first.learning_type = '$learningType' AND first.stage = '1'
                  return first");
         foreach ($learningRecords->records() as $record){
             $firstMatchingRecord = $record->get('first');
         }

         return $firstMatchingRecord->values();

    }

    public function matchNext($nameOfResource, $email, $course){

        return   $this->client->run(
            "MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (next:LearningResource)
                  where next.name_of_resource = '$nameOfResource' 
                 return next");

    }


    public function consumeItem($email, $name){
        return   $this->client->run(
            "MATCH (a:User { email: '$email' })
                  MATCH (first:LearningResource {name_of_resource: '$name'})
                 MERGE(a)-[r:Consumed]->(first)
                 return first");
    }

    public function connectUserWithFirstLearningItemStudying($nameOfResource,$course, $email){
        return $this->client->run(
            "
                   MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (n:LearningResource { name_of_resource: '$nameOfResource' })
                 MERGE(a)-[r:Consumed]->(n)");
    }


    public function findLatestConsumedItem($email){
        return $this->client->run(
            "MATCH (User {email: '$email'})-[:Consumed]->(LearningResource)  RETURN LearningResource.name_of_resource as name, max(LearningResource.stage) as max ORDER BY max DESC LIMIT 1"
        );
    }

    public function findLatestStage($learningType){
        return $this->client->run(
            "match (n:LearningResource{learning_type: \"$learningType\"})
                    RETURN max(n.stage) as stage, n.name_of_resource
                    ORDER BY stage DESC
                    LIMIT 1"
        );
    }




}