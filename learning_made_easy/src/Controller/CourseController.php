<?php

namespace App\Controller;

use App\Entity\Course;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends AbstractController
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Request $request)
    {
        $timestamp = date("Y-m-d H:i:s");
        $currentUser = $this->getUser();
        if(in_array('ROLE_USER', $currentUser->getRoles())){
            $course = new Course();
            $course->setName($request->get('name'));
            $course->setDateCreated($timestamp);
            $course->setUser($currentUser);
            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }

        return $this->json(['date' => 'success']);
    }
}
