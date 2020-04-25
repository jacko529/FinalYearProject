<?php

namespace App\Controller;

use App\CalculateLearningQuiz;
use App\Entity\LearningStyle;
use App\Repository\UserRepository;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LearningQuizController extends AbstractController
{

    protected TokenStorageInterface $tokenStorage;
    protected LearningStyle $learningStyle;
    protected object $entityManager;
    protected UserRepository $userRepository;


    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function calculate(Request $request)
    {
        $this->learningStyle = new LearningStyle();
        $allQuestions = $request->request->all();
        $learningStyles = new CalculateLearningQuiz($allQuestions);
        try {
            $output = $learningStyles->trigger();
            $learningStyles->clear();

        }catch (Exception $exception){
            return $this->json('You did not complete the quiz');
        }
        $token = $this->tokenStorage->getToken();
        if ($token instanceof TokenInterface) {
            $user = $token->getUser();
            $userEmail = $user->getUsername();
        }
        $currentLearningStyles = $this->userRepository->getLearningStyles($userEmail);
        if ($currentLearningStyles) {
            $this->userRepository->updateLearningStyles(
                $userEmail,
                $output
            );
        } else {
            $this->userRepository->createLearningStyle($userEmail, $output);
        }


        return $this->json(
            [
                $output
            ]
        );
    }


}
