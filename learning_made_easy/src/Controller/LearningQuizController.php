<?php

namespace App\Controller;

use App\CalculateLearningQuiz;
use App\Entity\LearningStyle;
use App\Repository\UserRepository;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $output = $learningStyles->trigger();

        $token = $this->tokenStorage->getToken();
        if ($token instanceof TokenInterface) {
            $user = $token->getUser();
            $userEmail = $user->getUsername();
        }
        $currentLearningStyles = $this->userRepository->getLearningStyles($userEmail);
        if ($currentLearningStyles) {
            $this->userRepository->updateLearningStyles(
                $userEmail,
                $output['global'],
                $output['reflector'],
                $output['intuitive'],
                $output['verbal']
            );
        } else {
            $this->learningStyle->setGlobal($output['global']);
            $this->learningStyle->setIntuitive($output['intuitive']);
            $this->learningStyle->setReflector($output['reflector']);
            $this->learningStyle->setVerbal($output['verbal']);
            $this->learningStyle->setUser($user);
            $this->entityManager->persist($this->learningStyle);
            $this->entityManager->flush();
        }


        return $this->json(
            [
                $output
            ]
        );
    }


}
