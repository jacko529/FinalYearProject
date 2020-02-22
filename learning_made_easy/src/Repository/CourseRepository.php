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
                    RETURN  b,resource"
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
