<?php

namespace App\Testing\Application;

use App\Testing\Domain\Entity\TestingSession;
use App\Testing\Domain\Repository\TestingSessionRepositoryInterface;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Testing\Domain\Repository\QuestionRepositoryInterface;

class TestingSessionService
{
    private UserRepositoryInterface $userRepository;
    private TestingSessionRepositoryInterface $testingSessionRepository;
    private QuestionRepositoryInterface $questionRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TestingSessionRepositoryInterface $testingSessionRepository,
        QuestionRepositoryInterface $questionRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->testingSessionRepository = $testingSessionRepository;
        $this->questionRepository = $questionRepository;
    }

    public function handleRequest(string $userName): TestingSession
    {
        $user = $this->userRepository->findByName($userName);
        if ($user === null) {
            $user = new User($userName);
            $this->userRepository->add($user);
        }

        $lastSession = $this->testingSessionRepository->findLatestByUserId($user);
        if ($lastSession === null) {
            $session = new TestingSession($user);
            $this->testingSessionRepository->add($session);
        } else {
            $session = $lastSession;
        }

        return $session;
    }
}