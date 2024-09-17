<?php

namespace App\Testing\Application;

use App\Testing\Domain\Entity\Answer;
use App\Testing\Domain\Entity\Question;
use App\Testing\Domain\Entity\TestingSession;
use App\Testing\Domain\Entity\UserResponse;
use App\Testing\Domain\Repository\TestingSessionRepositoryInterface;
use App\Testing\Domain\Repository\UserResponseRepositoryInterface;
use App\Users\Domain\Entity\User;

class UserResponseService
{
    private UserResponseRepositoryInterface $userResponseRepository;
    private TestingSessionRepositoryInterface $testingSessionRepository;

    public function __construct(
        UserResponseRepositoryInterface $userResponseRepository,
        TestingSessionRepositoryInterface $testingSessionRepository
    )
    {
        $this->userResponseRepository = $userResponseRepository;
        $this->testingSessionRepository = $testingSessionRepository;
    }

    public function handleRequest(Question $question, Answer $answer, User $user, TestingSession $testingSession)
    {
        $userResponse = new UserResponse($question, $answer, $user, $testingSession);
        $this->userResponseRepository->add($userResponse);

        $testingSession->addAnsweredQuestion($question->getId());
        $this->testingSessionRepository->updateAnsweredQuestion($testingSession);
    }

    public function getAllUserAnswersBySessionId(TestingSession $session): ?array
    {
        return $this->userResponseRepository->findBySession($session);
    }
}