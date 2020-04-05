<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use GraphAware\Neo4j\Client\ClientInterface;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository implements UserLoaderInterface
{


    protected EntityManagerInterface $client;
    protected ClientInterface $clients;

    public function __construct(EntityManagerInterface $client,
                                 ClientInterface $clients)
    {
        $this->client = $client;
        $this->clients = $clients;

    }


    public function loadUserByUsername($usernameOrEmail)
    {

        $this->client->getRepository(User::class)->findOneBy(['email' => $usernameOrEmail]);

    }



    public function findCourseCreatedByUser( $email){
        $courseValue = [];
         $courses = $this->clients->run(
            "MATCH (course:Course)-[:CREATED_BY]-(b:User)
                    where b.email = '$email'
                    RETURN  course"
        );

        foreach ($courses->records() as  $course) {
            $courseGet =    $course->get('course');
            $courseValue[] =  $courseGet->values();
        }
        return $courseValue;
    }


    public function updateLearningStyles($email, $global, $reflective, $intuitive, $verbal){
        return $this->clients->run(
           "
           MATCH (n:LearningStyle {active: true})<-[HAS]-(u:User {email: '$email'})
           SET n += {active:false }
           CREATE (LS:LearningStyle {active:true, global: '$global' , intuitive: '$intuitive', verbal: '$verbal', reflective: '$reflective' })
           CREATE (LS)<-[:HAS]-(u) 
           RETURN LS "
        );
    }

    public function getLearningStyles($userEmail){
        $learningStyles = [];
        $styles  = $this->clients->run(
            "MATCH (n:User{email: '$userEmail'})-[r:HAS]-(learningStyle:LearningStyle {active: true}) RETURN learningStyle LIMIT 1"
        );
        foreach($styles->records() as $style){
            $records = $style->get('learningStyle');
            $learningStyles = $records->values();
        }

        return $learningStyles;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
