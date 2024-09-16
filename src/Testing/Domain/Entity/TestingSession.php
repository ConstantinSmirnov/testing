<?php

namespace App\Testing\Domain\Entity;

use App\Users\Domain\Entity\User;

class TestingSession
{
    const QUESTION_COUNT = 10;

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

    public function addAnsweredQuestion(string $questionId)
    {
        $questionIds = explode(',', $this->questionCombination);
        $questionIds = array_filter($questionIds, fn($id) => $id !== '');
        if (!in_array($questionId, $questionIds)) {
            $questionIds[] = $questionId;
            $this->questionCombination = implode(',', $questionIds);
            if (count($questionIds) == self::QUESTION_COUNT-1) {
                $this->isEnd = true;
            }
        }
    }

}