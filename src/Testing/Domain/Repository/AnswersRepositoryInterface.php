<?php

namespace App\Testing\Domain\Repository;

use App\Testing\Domain\Entity\Answer;

interface AnswersRepositoryInterface
{
    public function findById(int $id): ?Answer;
}