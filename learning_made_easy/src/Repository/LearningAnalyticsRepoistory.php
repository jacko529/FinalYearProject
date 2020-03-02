<?php


namespace App\Repository;


use GraphAware\Neo4j\Client\ClientInterface;

class LearningAnalyticsRepoistory
{

    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }


    public function howManyPerCourse($courseName){
                $finalCount = 0;
               $count =    $this->client->run(
                   "MATCH (n:User)-[STUDYING]->(k:Course{name: '$courseName'})
                    RETURN count(n) as count");
               foreach($count->records() as $record){
                   $finalCount = $record->get('count');
               }
               return $finalCount;

    }

    public function howManyPeopleFinishedCourse($courseName, $stage){
        $doneCourse = 0;
        $finished =    $this->client->run(
            "MATCH (userFinished:User)-[STUDYING]->(k:Course{name: '$courseName'})
            with userFinished
            match (userFinished)-[Consumed]->(k:LearningResource{stage: '$stage'})
            RETURN count(userFinished) as finishedUser");
        foreach ($finished->records() as $record){
            $doneCourse = $record->get('finishedUser');
        }
        return $doneCourse;
    }


    public function averageTimePeopleWantOnCourse($courseName){
        $time = 0;
       $avgTime =  $this->client->run(
            "MATCH (n:User)-[STUDYING]->(Course{name: '$courseName'})
                RETURN avg(n.time) as avg_time"
        );
        foreach ($avgTime->records() as $record){
            $time = $record->get('avg_time');
        }
        return $time;
    }

    public function coursesCreate($email){
        $allCourses = [];
        $courses =     $this->client->run(
            "MATCH (userFinished:User {email: '$email'})-[CREATED_BY]->(course:Course)
                RETURN DISTINCT course.name as course_name");
        foreach($courses->records() as $record){
            $allCourses[] = $record->get('course_name');
        }
        return $allCourses;
    }


}