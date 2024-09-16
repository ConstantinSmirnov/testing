<?php

namespace App\Testing\Domain\Repository;

use App\Testing\Domain\Entity\Question;

interface QuestionRepositoryInterface
{
    public function findById(int $id): ?Question;
    public function findAllNotIn(array $ids): ?array;
    public function findAllQuestions(): ?array;
}