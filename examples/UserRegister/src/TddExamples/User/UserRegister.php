<?php
declare(strict_types=1);

namespace TddExamples\User;

class UserRegister
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerNewUser($username, $password): bool
    {
        if ($this->userRepository->existUser($username)) {
            throw new UserAlreadyExistException('User with this name already exist in the system');
        }

        if (!$this->userRepository->saveUser($username, $password)) {
            throw new \RuntimeException('Error when trying to save the new user in DB.');
        }

        return true;
    }
}