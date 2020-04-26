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

    public function connectWithPreviousLearningResource($course, $nameOfCurrent, $stage, $postStage, $timeBetween)
    {
        $lastStage = $this->lastStage($course);

        $this->client->run(
            "MATCH (a:LearningResource),(b:LearningResource)
             WHERE a.stage = $stage AND b.name_of_resource = '" . $nameOfCurrent . "'
             MERGE (a)-[ti:TimeDifficulty { time: $timeBetween }]->(b)"
        );


        //if it is
        if($postStage < $lastStage ){
            // if i had a new node in stage 3 - with a tme of 6 mins - connect to all the previous ones - to connect to the
            // ones in front i need to
            // target each node in front - find the leading relationship property - connect to said property
            // re run ran merge query for the on in front
            $this->re_mergeWithAllPrevious(($stage + 1), $postStage, $nameOfCurrent);
        }
    }


    public function re_mergeWithAllPrevious($currentStage, $nextStage, $nameif)
    {
        $this->client->run(

            "match (learning:LearningResource{name_of_resource: '$nameif'})
            match(lr:LearningResource{stage: $currentStage})-[s:TimeDifficulty]->(ss:LearningResource{stage: $nextStage})
             with [{matches: learning.name_of_resource , name: ss.name_of_resource, time: avg(s.time)}] as list
            UNWIND list AS event
            merge(first:LearningResource {name_of_resource: event.matches})
            merge(last:LearningResource {name_of_resource: event.name})
            merge(first)-[r:TimeDifficulty{time: event.time}]->(last)
             return r"
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
            "match (start:LearningResource {name_of_resource: \"$beginningStage\"}), (end:LearningResource{stage: $stage, learning_type: \"$learningType\"})
                    CALL algo.shortestPath.stream(start, end, \"time\") 
                    YIELD nodeId, cost
                    MATCH (LearningResource:LearningResource) WHERE id(LearningResource) = nodeId
                    RETURN LearningResource.name_of_resource AS name, cost "
        );
    }

    public function KshortestPath($beginningStage, $stage, $learningType)
    {
        return $this->client->run(
            "match (start:LearningResource {name_of_resource: '$beginningStage'}), (end:LearningResource{stage: $stage, learning_type: '$learningType'})
            CALL algo.kShortestPaths.stream(start, end, 3, 'time' ,{relationshipQuery:'TimeDifficulty'}) YIELD index, nodeIds, costs
            RETURN [node in algo.getNodesById(nodeIds) | node.name_of_resource] AS names,[node in algo.getNodesById(nodeIds) | node.learning_type] AS learning,costs,reduce(acc = 0.0, cost in costs | acc + cost) AS totalCost"
        );
    }


    public function KshortestPathLast($beginningStage, $stage, $learningType)
    {
        return $this->client->run(
            "match (start:LearningResource {name_of_resource: '$beginningStage'}), (end:LearningResource{stage: $stage})
            CALL algo.kShortestPaths.stream(start, end, 3, 'time' ,{relationshipQuery:'TimeDifficulty'}) YIELD index, nodeIds, costs
            RETURN [node in algo.getNodesById(nodeIds) | node.name_of_resource] AS names,[node in algo.getNodesById(nodeIds) | node.learning_type] AS learning,costs,reduce(acc = 0.0, cost in costs | acc + cost) AS totalCost"
        );
    }

    public function jaradCollabortiveFiltering($email)
    {
        return $this->client->run(
            "MATCH (p:User {email: \"$email\"})-[:NARROWER_THAN]->(other),
            (other)-[:Consumed]->(LearningResource)
            WHERE not((p)-[:Consumed]->(LearningResource))
            RETURN LearningResource.name_of_resource as name , LearningResource.stage AS index"
        );
    }

    public function reRunMatchingProcess()
    {
        return $this->client->run(
            "MATCH (p:User)-[:Consumed]->(LearningResource)
            WITH {item:id(p), categories: collect(id(LearningResource))} as userData
            WITH collect(userData) as data
            CALL algo.similarity.overlap(data, {topK: 1, similarityCutoff: 0.1, write:true})
            YIELD nodes, similarityPairs, write, writeRelationshipType, writeProperty, min, max, mean, stdDev, p25, p50, p75, p90, p95, p99, p999, p100
            RETURN nodes, similarityPairs, write, writeRelationshipType, writeProperty, min, max, mean, p95"
        );
    }


    public function deleteSimlarReltionships()
    {
        return $this->client->run(
            "match (:User)-[r:NARROWER_THAN]->(:User) delete r"
        );
    }

    public function compareTotalCostWithTime($beginningStage, $stage, $learningType)
    {
        return $this->client->run(
            "match (start:LearningResource {name_of_resource: \"$beginningStage\"}), (end:LearningResource{stage: \"$stage\", learning_type: \"$learningType\"})
                            CALL algo.shortestPath.stream(start, end, \"time\") 
                            YIELD  totalCost
                            RETURN totalCost "
        );
    }

    public function matchFirst($learningType, $email, $course)
    {
        $firstMatchingRecord = [];
        $learningRecords = $this->client->run(
            "MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (first:LearningResource)
                  where first.learning_type = '$learningType' AND first.stage = '1'
                  return first"
        );
        foreach ($learningRecords->records() as $record) {
            $firstMatchingRecord = $record->get('first');
        }

        return $firstMatchingRecord->values();
    }


    public function matchFirstUnion($email, $course)
    {
        $collectionOfFirstMatchingResources = [];

        $learningRecords = $this->client->run(
            "MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (b)-[td:TimeDifficulty]-(first:LearningResource {learning_type: 'global', stage: 1})
                  return first, td.time as time
            UNION      
            MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (b)-[td:TimeDifficulty]-(first:LearningResource {learning_type: 'reflective', stage: 1})
                  return first, td.time as time
            UNION 
            MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (b)-[td:TimeDifficulty]-(first:LearningResource {learning_type: 'verbal', stage: 1})
                  return first, td.time as time
            UNION 
            MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (b)-[td:TimeDifficulty]-(first:LearningResource {learning_type: 'intuitive', stage: 1})
                  return first, td.time as time"
        );
        foreach ($learningRecords->records() as $key => $record) {
            $firstMatchingRecord = $record->get('first');
            $time = $record->get('time');
            $collectionOfFirstMatchingResources[] = ['resource' => $firstMatchingRecord->values(), 'time' => $time];
        }
        return $collectionOfFirstMatchingResources;
    }


    public function findCourseStudiedByUser($email)
    {
        $courseValues = [];
        $courses = $this->client->run(
            "MATCH (course:Course)-[:STUDYING]-(b:User)
                    where b.email = '$email'
                    RETURN  course"
        );
        foreach ($courses->records() as $course) {
            $courseGet = $course->get('course');
            $courseValues[] = $courseGet->values();
        }
        return $courseValues;
    }


    public function matchNext($nameOfResource, $email, $course, $lastItem)
    {
        $correctReturn = [];
        $query = $this->client->run(
            "  MATCH (a:User { email: '$email' })
                MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                -[firstTime:TimeDifficulty*]->(next:LearningResource {name_of_resource: '$lastItem'})-[time:TimeDifficulty*]
                ->(correctItem:LearningResource {name_of_resource: '$nameOfResource'})
                return correctItem, time"
        );
        foreach ($query->records() as $index => $record) {
            $resource = $record->get('correctItem');
            $time = $record->get('time');
            if (!empty($record->get('time'))) {
                $size = sizeof($record->get('time'));
            }
            $correctReturn['resource'] = $resource->values();
            $time = $time[$size - 1]->values();
            $correctReturn['time'] = $time['time'];
        }
        return $correctReturn;
    }


    public function consumeItem($email, $name)
    {
        return $this->client->run(
            "MATCH (a:User { email: '$email' })
                  MATCH (first:LearningResource {name_of_resource: '$name'})
                 MERGE(a)-[r:Consumed]->(first)
                 return first"
        );
    }

    public function connectUserWithFirstLearningItemStudying($nameOfResource, $course, $email)
    {
        return $this->client->run(
            "
                   MATCH (a:User { email: '$email' })
                  MATCH (a)-[:STUDYING]-(b:Course { name: '$course' })
                  MATCH (n:LearningResource { name_of_resource: '$nameOfResource' })
                 MERGE(a)-[r:Consumed]->(n)"
        );
    }


    public function findLatestConsumedItem($course, $email)
    {
        return $this->client->run(
            "MATCH (User {email: '$email'})-[:STUDYING]->(s:Course {name: '$course'})
             MATCH (User {email: '$email'})-[:Consumed]->(LearningResource) return LearningResource.name_of_resource as name, max(LearningResource.stage) as max ORDER BY max DESC LIMIT 1"
        );
    }

    public function findAllCoursesUserBelongsTo($email)
    {
        return $this->client->run(
            "MATCH (User {email: '$email'})-[:Studying]->(c:Courses)  RETURN c.name  as course "
        );
    }

    public function lastStage($course){
        $stage  = 0;
        $clientQuery = $this->client->run(
            "MATCH (s:Course {name: '$course'})-[:TimeDifficulty*]->(n:LearningResource)
            RETURN max(n.stage) as stage"
        );
        foreach($clientQuery->records()  as $query){
            $stage = $query->get('stage');
        }
        return $stage;
    }

    public function findPreferredLatestStage($email, $course, $learningType)
    {
        $keys = array_keys($learningType);
        $stage = [];
        $preferredLastStage =  $this->client->run(
            "MATCH (User {email: '$email'})-[:STUDYING]->(s:Course {name: '$course'})
            OPTIONAL MATCH (n:LearningResource{learning_type: \"$keys[0]\"})
            RETURN max(n.stage) as stage, n.learning_type as name
            ORDER BY stage DESC
            LIMIT 1
            UNION
            MATCH (User {email: '$email'})-[:STUDYING]->(s:Course {name: '$course'})
            OPTIONAL MATCH (n:LearningResource{learning_type: \"$keys[1]\"})
            RETURN max(n.stage) as stage, n.learning_type as name
            ORDER BY stage DESC
            LIMIT 1"
        );
        foreach($preferredLastStage->records() as $stages){
            $stage[] = [ 'stage' => $stages->get('stage') , 'style' =>  $stages->get('name')];


        }
        $array = array_filter(array_map('array_filter', $stage));
        if (count($array) > 1){
            $array = $array[0];
        }

        return $array;
    }

    public function findResource($name)
    {
        $resourceGet = '';
        $learningResource = $this->client->run(
            "MATCH (lr:LearningResource {name_of_resource: '$name'})
                    RETURN  lr.name_of_resource as lr"
        );
        foreach ($learningResource->records() as $available) {
            $resourceGet = $available->get('lr');
        }

        return $resourceGet;
    }

    public function findLastStageOfCourse($course)
    {
        $lastStage = 0;
        $query = $this->client->run(
                "MATCH (course:Course {name: '$course'})-[:TimeDifficulty*]->(n:LearningResource)
                 RETURN max(n.stage) as stage"
        );
        foreach ($query->records() as $record) {
            $lastStage = $record->values();
        }

        return intval($lastStage[0]);
    }


}