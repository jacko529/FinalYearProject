<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected CourseRepository $courseRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                CourseRepository $courseRepository)
    {
        $this->entityManager = $entityManager;
        $this->courseRepository = $courseRepository;
    }

    public function getAllCoursesYouCreated(Request $request){
        $currentUser = $this->getUser();
        foreach ( $currentUser->getCourse() as $styles) {
            $course['course_name'] = $styles->getName();
            $course['date_created']  = $styles->getDateCreated();
        }
        if(!$course){
            $course = [];
        }
        return $this->json(['data'=>$course]);
    }



    public function getAllCoursesWithRelatedLearningObjects(){
        $currentUser = $this->getUser();
        $response = $this->courseRepository->grabAllPreviousResources($currentUser->getEmail());

        foreach($response->records() as $record){
            $courseRelated = $record->get('b');
            $learningCourseResource =  $record->get('resource');
                $resources = $learningCourseResource->values();
                $courses = $courseRelated->values();
                $arrayOfRelatedResources['related_courses'][] = [$courses, $resources ];
        }
        return $this->json($arrayOfRelatedResources);
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
