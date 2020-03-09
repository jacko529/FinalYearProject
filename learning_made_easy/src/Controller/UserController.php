<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\LearningResourceRepository;
use App\Repository\UserRepository;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{


    protected object $entityManager;
    private UserPasswordEncoderInterface $userPasswordEncoder;
    protected TokenStorageInterface $tokenStorage;
    protected JWTEncoderInterface $jwtEncoder;
    protected array $learningStyles = [];
    protected array $courses = [];
    protected UserRepository $userRepository;
    protected array $arrayOfRelatedResources;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $userPasswordEncoder,
        TokenStorageInterface $tokenStorage,
        JWTEncoderInterface $JWTEncoder,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->jwtEncoder = $JWTEncoder;
        $this->userRepository = $userRepository;
    }


    public function index()
    {

        $user = $this->getUser();
        $userEntitys = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUsername()]);

        $userEntity = $this->userRepository->getLearningStyles($user->getUsername());
        foreach($userEntity->records() as $style){
            $records = $style->get('learningStyle');
            $this->learningStyles = $records->values();
        }

        if($this->learningStyles){
            arsort($this->learningStyles, SORT_REGULAR);
        }
        $courses = $this->userRepository->findCourseByUser($user->getUsername());
        $this->arrayOfRelatedResources = [];
        foreach ($courses->records() as  $course) {
                $courseGet =    $course->get('course');
                       $courseValue =  $courseGet->values();
                       $this->arrayOfRelatedResources =  $courseValue;
        }
        if($this->arrayOfRelatedResources === null){
            $this->arrayOfRelatedResources = [];
        }

        return $this->json([
            'first_name' => $userEntitys->getFirstName(),
            'surname' => $userEntitys->getSurname(),
            'email' => $userEntitys->getEmail(),
            'user_type' => $userEntitys->getRoles(),
            'time' => $userEntitys->getTime() ?: '',
            'learning_styles' => $this->learningStyles,
            'course_created' => $this->arrayOfRelatedResources
        ]);


    }

    //@todo validation and cater for if email is not unique
    public function create(Request $request)
    {

        try {
            $user = new User();
            $user->setFirstName($request->get('first_name'));
            $user->setSurname($request->get('surname'));
            $user->setEmail($request->get('email'));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $request->get('password')));
            $user->setRoles(['ROLE_USER']);
            $user->getLearningStyles();
            // @todo what if they are already a user
            $this->entityManager->persist($user);
                $this->entityManager->flush();
                $token = $this->jwtEncoder->encode([
                  'username' => $user->getUsername(),
                    'exp' => time() + 3600 // 1 hour expiration
              ]);
                $reply = 'success';
//            }else{
//                $reply = 'failure';
//                $token = 'A user already has this email address`';
//            }

        } catch (Exception $exception) {
            return $this->json('A user already has this email address');
        }

        return $this->json([
            'data' => $reply,
            'access_token' => $token
        ]);
    }

    public function saveTime(Request $request){

        $user = $this->getUser();
        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUsername()]);
        $userEntity->setTime($request->get('time'));
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();

        return $this->json('success');

    }
}
