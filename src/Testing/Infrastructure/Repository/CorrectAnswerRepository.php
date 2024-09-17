<?php

namespace App\Testing\Infrastructure\Repository;

use App\Testing\Domain\Entity\CorrectAnswer;
use App\Testing\Domain\Repository\CorrectAnswerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CorrectAnswerRepository extends ServiceEntityRepository implements CorrectAnswerRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CorrectAnswer::class);
    }

    public function findAllAnswersByQuestionId(int $id): ?array
    {
        return $this->findBy(['question' => $id]);
    }
}