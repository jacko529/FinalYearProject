<?php

namespace App\Controller;

use App\Classes\FindTopLearningStyle;
use App\Entity\User;
use App\Repository\LearningResourceRepository;
use App\Repository\UserRepository;
use App\Validation\UserValidation;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;


class UserController extends AbstractController
{


    protected object $entityManager;
    private UserPasswordEncoderInterface $userPasswordEncoder;
    protected TokenStorageInterface $tokenStorage;
    protected JWTEncoderInterface $jwtEncoder;
    protected array $courses = [];
    protected UserRepository $userRepository;
    protected FindTopLearningStyle $topLearningstyle;
    protected UserValidation $registerValidation;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $userPasswordEncoder,
        TokenStorageInterface $tokenStorage,
        JWTEncoderInterface $JWTEncoder,
        UserRepository $userRepository,
        FindTopLearningStyle $topLearningstyle,
        UserValidation $registerValidation
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->jwtEncoder = $JWTEncoder;
        $this->userRepository = $userRepository;
        $this->topLearningstyle = $topLearningstyle;
        $this->registerValidation = $registerValidation;
    }


    public function index()
    {
        $user = $this->getUser();
        $userEntitys = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUsername()]);
        $learningStyles = $this->userRepository->getLearningStyles($user->getUsername());
        if ($learningStyles) {
            arsort($learningStyles, SORT_REGULAR);
        }else{
            $learningStyles = [];
        }
        $courses = $this->userRepository->findCourseCreatedByUser($user->getUsername());
        if ($courses === null) {
            $courses = [];
        }

        return $this->json(
            [
                'first_name' => $userEntitys->getFirstName(),
                'surname' => $userEntitys->getSurname(),
                'email' => $userEntitys->getEmail(),
                'user_type' => $userEntitys->getRoles(),
                'time' => $userEntitys->getTime() ?: '',
                'learning_styles' => $learningStyles,
                'course_created' => $courses
            ]
        );
    }

    public function create(Request $request)
    {
        $validate = $this->registerValidation->validate($request->request->all());
        if($validate) {
            return $this->json(['access_token' => $validate], 403);
        }

        try {
            $user = new User();
            $user->setFirstName($request->get('first_name'));
            $user->setSurname($request->get('surname'));
            $user->setEmail($request->get('email'));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $request->get('password')));
            $user->setRoles(['ROLE_USER']);
            $user->getLearningStyles();
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $token = $this->jwtEncoder->encode(
                [
                    'username' => $user->getUsername(),
                    'exp' => time() + 3600 // 1 hour expiration
                ]
            );
            $reply = 'success';

        } catch (Exception $exception) {
            return $this->json('A user already has this email address');
        }

        return $this->json(
            [
                'data' => $reply,
                'access_token' => $token
            ]
        );
    }

    public function saveTime(Request $request)
    {
        $user = $this->getUser();
        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUsername()]);
        $userEntity->setTime(intval($request->get('time')));
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();

        return $this->json('success');
    }
}
