<?php
declare(strict_types=1);

namespace TddExamples\User;


class InMemoryUserRepository implements UserRepository
{
    private $users;

    public function __construct()
    {
        $this->users = [];
    }

    public function saveUser($username, $password): bool
    {
        $this->users[$username] = $password;

        return true;
    }

    public function existUser($username): bool
    {
        return isset($this->users[$username]);
    }
}