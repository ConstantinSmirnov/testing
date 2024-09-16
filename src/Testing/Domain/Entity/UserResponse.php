<?php

namespace App\Testing\Domain\Entity;

use App\Users\Domain\Entity\User;

class UserResponse
{
    private int $id;
    private Question $question;
    private Answer $answer;
    private User $user;
    private TestingSession $testingSession;

    public function __construct(Question $question, Answer $answer, User $user, TestingSession $testingSession)
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->user = $user;
        $this->testingSession = $testingSession;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function getAnswer(): Answer
    {
        return $this->answer;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTestingSession(): TestingSession
    {
        return $this->testingSession;
    }

    public function setAnswer(Answer $answer)
    {
        $this->answer = $answer;
    }
}