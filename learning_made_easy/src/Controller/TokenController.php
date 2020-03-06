<?php

namespace App\Controller;

use App\Entity\User;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class TokenController extends AbstractController
{

    protected EntityManagerInterface $entityManager;
    protected UserPasswordEncoderInterface $passwordEncoder;
    protected JWTEncoderInterface $jwtEncoder;
    protected String $response;
    protected Int $statusCode;

    public function __construct(EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder,
                                JWTEncoderInterface $JWTEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->jwtEncoder = $JWTEncoder;
    }

    public function Token(Request $request)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email'=>$request->get('username')]);
        if (!$user) {
            $this->response = 'Your are not a user currently';
            $this->statusCode = 500;
        }

        $isValid = $this->passwordEncoder->isPasswordValid($user,$request->get('password'));
        if (!$isValid) {
            $this->response = 'Incorrect Credentials';
            $this->statusCode = 500;
        }else{
            $this->response = $this->jwtEncoder->encode([
                'username' => $request->get('username'),
                'exp' => time() + 3600 // 1 hour expiration
            ]);
            $this->statusCode = 200;
        }
        return $this->json(['access_token' => $this->response], $this->statusCode);
    }


}
