<?php

namespace App\Testing\Domain\Entity;

class CorrectAnswer
{
    private int $id;
    private Question $question;
    private string $combination;

    public function __construct(Question $question, string $combination)
    {
        $this->question = $question;
        $this->combination = $combination;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function getCombination(): string
    {
        return $this->combination;
    }
}