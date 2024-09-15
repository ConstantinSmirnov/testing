<?php

namespace App\Testing\Application;

use App\Testing\Domain\Entity\TestingSession;
use App\Testing\Domain\Repository\QuestionRepositoryInterface;

class QuestionService
{
    private QuestionRepositoryInterface $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function handleRequest(TestingSession $testingSession)
    {
        if ($testingSession->getQuestion() !== '') {
            $answeredQuestions = explode(',', $testingSession->getQuestion());
            $questions = $this->questionRepository->findAllNotIn($answeredQuestions);
        } else {
            $questions = $this->questionRepository->findAll();
        }

        shuffle($questions);

        return $questions;
    }

}