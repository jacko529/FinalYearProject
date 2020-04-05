<?php

namespace App\Controller;

use App\Classes\S3Helper;
use App\Entity\Course;
use App\Entity\User;
use App\Repository\CourseRepository;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected CourseRepository $courseRepository;
    protected $s3;

    public function __construct(
        EntityManagerInterface $entityManager,
        CourseRepository $courseRepository
    ) {
        $this->s3 = new S3Helper();
        $this->entityManager = $entityManager;
        $this->courseRepository = $courseRepository;
    }


    /**
     * Function to get all courses the individual created, aimed at educators
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllCoursesYouCreated(Request $request)
    {
        $currentUser = $this->getUser();
        foreach ($currentUser->getCourse() as $styles) {
            $course['course_name'] = $styles->getName();
            $course['date_created'] = $styles->getDateCreated();
        }
        if (!$course) {
            $course = [];
        }
        return $this->json(['data' => $course]);
    }

    public function getAll(Request $request)
    {
        $user = $this->getUser();
        // get the first user
        $usersEmail = $user->getEmail();

        $response = $this->courseRepository->getAllPreviousCoursesNotStudied($usersEmail);

        return $this->json(['data' => $response]);
    }


    public function getAllCoursesWithRelatedLearningObjects()
    {
        $currentUser = $this->getUser();
        $response = $this->courseRepository->grabAllPreviousResources($currentUser->getEmail());

        foreach ($response->records() as $record) {
            $courseRelated = $record->get('resource');
            $stage = $record->get('stage');
            $learningCourseResource = $record->get('course_name');
            $learningType = $record->get('type');

            $arrayOfRelatedResources[] = [
                'course' => $courseRelated,
                'stage' => $stage,
                'resource' => $learningCourseResource,
                'type' => $learningType
            ];
        }
        return $this->json($arrayOfRelatedResources);
    }

    /**
     * Function to allote a course for the student to study
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function studyingNow(Request $request)
    {
        $currentUser = $this->getUser();
        $course = $request->get('course');
        $this->courseRepository->addCourseRelationship($currentUser->getEmail(), $course);
        return $this->json('success');
    }

    /**
     *
     * Function to create course
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $requests = $request->request->all();
        $json = json_decode($requests['json'], true);
        $this->s3->checkBucketsAgainstCourse($json['name']);
        $file = $request->files->get('file');
        $fileName = $this->s3->upload($file, $json['name']);

        $timestamp = date("Y-m-d H:i:s");
        $currentUser = $this->getUser();
        if (in_array('ROLE_USER', $currentUser->getRoles())) {
            $course = new Course();
            $course->setName($json['name']);
            $course->setDateCreated($timestamp);
            $course->setUser($currentUser);
            $course->setImage($fileName);
            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }

        return $this->json(['date' => 'success']);
    }
}
