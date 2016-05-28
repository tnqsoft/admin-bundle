<?php

namespace TNQSoft\AdminBundle\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use TNQSoft\AdminBundle\Entity\User;
use TNQSoft\AdminBundle\Repository\UserRepository;
use TNQSoft\AdminBundle\Exception\User\UserNotFoundException;
use TNQSoft\AdminBundle\Exception\User\UnAuthorizedException;

class UserService extends BaseService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var [type]
     */
    private $securityEncoder;

    /**
     * Set UserRepository.
     *
     * @param UserRepository $userRepository
     */
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Set SecurityEncoder.
     *
     * @param UserRepository $securityEncoder
     */
    public function setSecurityEncoder(UserPasswordEncoder $securityEncoder)
    {
        $this->securityEncoder = $securityEncoder;
    }

    /**
     * Login
     *
     * @param  string $username
     * @param  string $password
     * @return User
     * @throws UserNotFoundException If user not found
     * @throws UnAuthorizedException If username or password wrong
     */
    public function login($username, $password)
    {
        $user = $this->userRepository->loadUserByUsername($username);
        if (null === $user) {
            throw new UserNotFoundException(404, "User {$username} not found");
        }

        $passwordValid = $this->securityEncoder->isPasswordValid($user, $password);
        if(false === $passwordValid) {
            throw new UnAuthorizedException(401, "Username or Password wrong");
        }

        return $user;
    }

    /**
     * Load User By Username
     *
     * @param  string $username [description]
     * @return User
     * @throws UserNotFoundException If user not found
     */
    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->loadUserByUsername($username);
        if (null === $user) {
            throw new UserNotFoundException(404, "User {$username} not found");
        }

        return $user;
    }

}
