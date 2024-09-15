<?php

namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;

class UserFactory
{
    public function create(string $name): User
    {
        return new User($name);
    }
}