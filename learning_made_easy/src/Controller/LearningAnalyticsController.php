<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\LearningAnalyticsRepoistory;
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

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        JWTEncoderInterface $JWTEncoder,
        LearningAnalyticsRepoistory $learningAnalyticsRepo
    ) {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->jwtEncoder = $JWTEncoder;
        $this->learningAnalyticsRepo = $learningAnalyticsRepo;
    }

    public function getAnalytics(Request $request)
    {
        $courseInformation = [];

        $user = $this->getUser();
        $userEmail = $user->getUsername();
        $coursesCreated = $this->learningAnalyticsRepo->coursesCreate($userEmail);
        foreach ($coursesCreated as $courses) {
            $courseInformation['courses'][] = [
                'course' => $courses,
                'count' => $this->learningAnalyticsRepo->howManyPerCourse($courses),
                'finished' => $this->learningAnalyticsRepo->howManyPeopleFinishedCourse($courses, '8'),
                'avg_time_wanted' => round($this->learningAnalyticsRepo->averageTimePeopleWantOnCourse($courses), 2)
            ];
        }

        if (empty($courseInformation)) {
            $courseInformation = ['no courses'];
        }
        return $this->json($courseInformation);
    }


}
