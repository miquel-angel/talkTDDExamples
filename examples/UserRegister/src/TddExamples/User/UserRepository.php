<?php

namespace TddExamples\User;


interface UserRepository
{
    public function existUser($username): bool;

    public function saveUser($username, $password): bool;
}