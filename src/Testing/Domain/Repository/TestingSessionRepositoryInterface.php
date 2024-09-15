<?php

namespace App\Testing\Domain\Repository;

use App\Testing\Domain\Entity\TestingSession;
use App\Users\Domain\Entity\User;

interface TestingSessionRepositoryInterface
{
    public function add(TestingSession $testingSession): void;
    public function findById(int $id): ?TestingSession;
    public function findLatestByUserId(User $userUlid): ?TestingSession;
}