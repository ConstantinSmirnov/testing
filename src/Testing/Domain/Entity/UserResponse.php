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
}