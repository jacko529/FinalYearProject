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
            $learningStyles['verbal'] = $styles->getVerbal();
            $learningStyles['intuitive'] = $styles->getIntuitive();
            $learningStyles['reflector'] = $styles->getReflector();
            $learningStyles['global'] = $styles->getGlobal();
            break;
        }
        arsort($learningStyles, SORT_REGULAR);


        return $this->json([
            'first_name' => $userEntity->getFirstName(),
            'surname' => $userEntity->getSurname(),
            'email' => $userEntity->getEmail(),
            'learning_styles' => $learningStyles
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
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $token = $this->jwtEncoder->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);
        } catch (Exception $exception) {
            return $this->json($exception->getMessage());
        }

        return $this->json([
            'data' => 'success',
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
