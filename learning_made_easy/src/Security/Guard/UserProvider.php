<?php
// src/Security/UserProvider.php
namespace App\Security\Guard;


use App\Entity\User;
use App\Manager\EntityManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    protected $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->userRepository = $entityManager->getEntityManager()->getRepository(User::class);
    }

    /**
     * @param string $username
     * @return null|User
     */
    public function loadUserByUsername($username)
    {
         $ko = $this->userRepository->findOneBy(['username' => $username]);
         return
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instance of %s is not support', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }

}