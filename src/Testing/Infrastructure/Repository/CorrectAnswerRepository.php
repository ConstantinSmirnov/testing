<?php

namespace Testing\Infrastructure\Controller;

use App\Testing\Domain\Repository\CorrectAnswerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CorrectAnswerRepository extends ServiceEntityRepository implements CorrectAnswerRepositoryInterface
{
    public function findAllAnswersByQuestionId(int $id): array
    {
        return $this->findBy(['question' => $id]);
    }
}