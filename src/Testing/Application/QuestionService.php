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
            $questions = $this->questionRepository->findAllQuestions();
        }

        shuffle($questions);

        return $questions;
    }

    public function findQuestionById(int $id)
    {
        return $this->questionRepository->findById($id);
    }

    public function getQuestionsWithAnswers(TestingSession $testingSession): array
    {
        $result = [];
        foreach ($this->handleRequest($testingSession) as $question) {
            $answers = $question->getAnswers();

            $answersArray = [];
            foreach ($answers as $answer) {
                $answersArray[] = ['id' => $answer->getId(), 'text' => $answer->getText()];
            }

            shuffle($answersArray);

            $result[] = [
                'question' => ['id' => $question->getId(), 'text' => $question->getText()],
                'answers' => $answersArray
            ];
        }

        return $result;
    }

}