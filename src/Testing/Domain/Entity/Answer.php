<?php

namespace App\Testing\Domain\Entity;

class Answer
{
    private int $id;
    private ?Question $question;
    private string $text;

    public function __construct(Question $question, string $text)
    {
        $this->question = $question;
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): void
    {
        $this->question = $question;
    }
}