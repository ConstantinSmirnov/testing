<?php

namespace App\Testing\Domain\Repository;

use App\Testing\Domain\Entity\UserResponse;

interface UserResponseRepositoryInterface
{
    public function add(UserResponse $userResponse): void;
}