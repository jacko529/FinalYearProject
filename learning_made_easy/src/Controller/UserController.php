<?php

namespace App\Controller;

use App\Entity\User;
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


    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $userPasswordEncoder,
        TokenStorageInterface $tokenStorage,
        JWTEncoderInterface $JWTEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->jwtEncoder = $JWTEncoder;
    }


    public function index()
    {

        $user = $this->getUser();
        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUsername()]);

        foreach ($userEntity->getLearningStyles() as $styles) {
            $this->learningStyles['verbal'] = $styles->getVerbal();
            $this->learningStyles['intuitive'] = $styles->getIntuitive();
            $this->learningStyles['reflector'] = $styles->getReflector();
            $this->learningStyles['global'] = $styles->getGlobal();
            break;
        }
        if($this->learningStyles){
            arsort($this->learningStyles, SORT_REGULAR);
        }

        foreach ($userEntity->getCourse() as $key => $course) {
                    $this->courses[] =  ['name'=>$course->getName(),
                                        'date' => $course->getDateCreated()];

        }


        return $this->json([
            'first_name' => $userEntity->getFirstName(),
            'surname' => $userEntity->getSurname(),
            'email' => $userEntity->getEmail(),
            'time' => $userEntity->getTime() ?: '',
            'learning_styles' => $this->learningStyles,
            'course_created' => $this->courses
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
            if($this->entityManager->persist($user)){
                $this->entityManager->flush();
                $token = $this->jwtEncoder->encode([
                  'username' => $user->getUsername(),
                    'exp' => time() + 3600 // 1 hour expiration
              ]);
                $reply = 'success';
            }else{
                $reply = 'failure';
                $token = 'A user already has this email address`';
            }

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
