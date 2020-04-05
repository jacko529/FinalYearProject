<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use GraphAware\Neo4j\Client\ClientInterface;


class CourseRepository
{
    protected ClientInterface $client;

    public function __construct( ClientInterface $client)
    {
        $this->client = $client;

    }
    public function grabAllPreviousResources($email){
        return $this->client->run(
            "MATCH (a:User)-[:CREATED_BY]-(b:Course)-[:TimeDifficulty]-(resource:LearningResource)
                    where a.email = '$email'
                    RETURN resource.name_of_resource as resource, resource.stage as stage ,b.name as course_name, resource.learning_type as type
                    order by b.name, resource.stage"
        );
    }

    public function getAllPreviousCoursesNotStudied($email){
        $courses = [];
        $query = $this->client->run(
            "MATCH (p:Course)
            WHERE NOT (p)<-[:STUDYING]-(:User {email: '$email'})
            RETURN p.name as course"
        );
        foreach ($query->records() as $course){
            $courses[] = $course->get('course');
        }
        $courseTrue = empty($courses) ? ['No courses left'] : $courses;
        return $courseTrue;
    }

    public function addCourseRelationship($email, $name){
        return $this->client->run(
            "MATCH (a:User { email: '$email' })
                     MATCH (b:Course { name: '$name' })
                 MERGE(a)-[r:STUDYING]->(b)"
        );
    }
    // /**
    //  * @return Course[] Returns an array of Course objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Course
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
