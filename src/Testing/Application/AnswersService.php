<?php

namespace App\Testing\Application;

use App\Testing\Domain\Entity\Answer;
use App\Testing\Domain\Repository\AnswersRepositoryInterface;

class AnswersService
{
    private AnswersRepositoryInterface $answersRepository;

    public function __construct(AnswersRepositoryInterface $answersRepository)
    {
        $this->answersRepository = $answersRepository;
    }

    public function findAnswerById(int $id): ?Answer
    {
        return $this->answersRepository->findById($id);
    }
}