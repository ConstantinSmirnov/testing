<?php

namespace App\Testing\Domain\Entity;

use App\Users\Domain\Entity\User;

class TestingSession
{
    private int $id;
    private bool $isEnd;
    private string $questionCombination;
    private User $user;

    public function __construct(User $user, string $questionCombination = '')
    {
        $this->isEnd = false;
        $this->questionCombination = $questionCombination;
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getQuestion(): string
    {
        return $this->questionCombination;
    }

    public function isEnd(): bool
    {
        return $this->isEnd;
    }

}