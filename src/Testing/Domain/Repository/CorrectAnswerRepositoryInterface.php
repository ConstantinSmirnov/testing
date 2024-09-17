<?php

namespace App\Testing\Domain\Repository;

interface CorrectAnswerRepositoryInterface
{
    public function findAllAnswersByQuestionId(int $id): ?array;
}