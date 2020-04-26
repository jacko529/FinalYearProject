<?php

namespace App\Controller;

use App\Repository\LearningAnalyticsRepoistory;
use App\Repository\LearningResourceRepository;
use App\Repository\UserRepository;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class LearningAnalyticsController extends AbstractController
{

    protected EntityManagerInterface $entityManager;
    protected UserPasswordEncoderInterface $passwordEncoder;
    protected JWTEncoderInterface $jwtEncoder;
    protected LearningAnalyticsRepoistory $learningAnalyticsRepo;
    protected LearningResourceRepository $learningResourceRepo;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        JWTEncoderInterface $JWTEncoder,
        LearningAnalyticsRepoistory $learningAnalyticsRepo,
        LearningResourceRepository $learningResourceRepository
    ) {
        $this->learningResourceRepo = $learningResourceRepository;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->jwtEncoder = $JWTEncoder;
        $this->learningAnalyticsRepo = $learningAnalyticsRepo;
    }

    public function getAnalytics(Request $request)
    {
        $courseInformation = [];
        // get the most popular route
        // get most common learning style

        $user = $this->getUser();
        $userEmail = $user->getUsername();
        $coursesCreated = $this->learningAnalyticsRepo->coursesCreate($userEmail);


        foreach ($coursesCreated as $courses) {
            $lastStageOfCourse = $this->learningResourceRepo->findLastStageOfCourse($courses);

            $courseInformation['courses'][] = [
                'course' => $courses,
                'count' => $this->learningAnalyticsRepo->howManyPerCourse($courses),
                'finished' => $this->learningAnalyticsRepo->howManyPeopleFinishedCourse($courses, $lastStageOfCourse),
//                'avg_time_wanted' => round($this->learningAnalyticsRepo->averageTimePeopleWantOnCourse($courses), 2),
                'most_popular_resources' => $this->learningAnalyticsRepo->topResourcesPerCourse($courses),
                'most_popular_learning_style' => $this->learningAnalyticsRepo->topStyleOfEachCourse($courses)
            ];
        }

        if (empty($courseInformation)) {
            $courseInformation = ['no courses'];
        }
        return $this->json($courseInformation);
    }
}
