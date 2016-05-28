<?php

namespace TNQSoft\AdminBundle\Security\Provider;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use TNQSoft\AdminBundle\Entity\User;
use TNQSoft\AdminBundle\Service\UserService;

/**
 * Class WebserviceUserProvider
 *
 * @package TNQSoft\AdminBundle\Security\Provider
 */
class WebserviceUserProvider implements UserProviderInterface
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * Set UserService
     *
     * @param UserService $userService
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        return $this->userService->loadUserByUsername($username);
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $user;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'TNQSoft\AdminBundle\Entity\User';
    }
}
