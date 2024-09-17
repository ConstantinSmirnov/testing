<?php

namespace App\Testing\Application;

use App\Testing\Domain\Repository\CorrectAnswerRepositoryInterface;

class CorrectAnswerService
{
    private CorrectAnswerRepositoryInterface $correctAnswerRepository;

    public function __construct(CorrectAnswerRepositoryInterface $correctAnswerRepository)
    {
        $this->correctAnswerRepository = $correctAnswerRepository;
    }

    public function getAllAnswers(int $id): ?array
    {
        return $this->correctAnswerRepository->findAllAnswersByQuestionId($id);
    }
}