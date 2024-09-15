<?php

namespace App\Testing\Domain\Entity;

use App\Testing\Domain\Enum\QuestionTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Question
{
    private int $id;
    private string $text;
    private QuestionTypeEnum $type;

    /** @var Answer[]|Collection */
    private Collection|array $answers;

    public function __construct(string $text, QuestionTypeEnum $type)
    {
        $this->text = $text;
        $this->type = $type;
        $this->answers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getType(): QuestionTypeEnum
    {
        return $this->type;
    }

    /**
     * @return Collection
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): void
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }
    }

    public function removeAnswer(Answer $answer): void
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            $answer->setQuestion(null);
        }
    }

}