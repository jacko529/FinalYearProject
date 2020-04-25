<?php

namespace App\Security\Guard;

use App\Entity\User;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;


class JwtTokenAuthenticatorNEO extends AbstractGuardAuthenticator
{

    private $JWTEncoder;
    private $entityManager;
    private $dispatcher;
    private $userProvider;
    private $router;

    public function __construct(JWTEncoderInterface $JWTEncoder,
        EventDispatcherInterface $dispatcher,
        EntityManagerInterface $entityManager,
        UserProviderInterface $userProvider
       )
    {
        $this->JWTEncoder = $JWTEncoder;
        $this->dispatcher = $dispatcher;
        $this->userProvider = $userProvider;
        $this->entityManager = $entityManager;
    }



    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->headers->has('Authorization');
    }


    public function getCredentials(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor(
          'Bearer', 'Authorization',
        );
        $token = $extractor->extract($request);
        if(!$token) {
            return;
        }
        return $token;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $data = $this->JWTEncoder->decode($credentials);
        if($data === false) {
            throw new CustomUserMessageAuthenticationException('Invalid token');
        }

        $username = $data['username'];
        return $this->entityManager->getRepository(User::class)->findOneBy(['email'=>$username]);
    }


    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse('Hello!', 401);
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return;
    }


    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }


}