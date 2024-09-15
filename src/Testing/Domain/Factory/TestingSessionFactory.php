<?php

namespace App\Testing\Domain\Factory;

use App\Testing\Domain\Entity\TestingSession;
use App\Users\Domain\Entity\User;
use JetBrains\PhpStorm\Pure;

class TestingSessionFactory
{
    #[Pure]
    public function create(User $user): TestingSession
    {
        return new TestingSession($user);
    }

}