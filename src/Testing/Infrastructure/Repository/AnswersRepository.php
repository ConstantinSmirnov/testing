<?php

namespace App\Testing\Infrastructure\Repository;

use App\Testing\Domain\Entity\Answer;
use App\Testing\Domain\Repository\AnswersRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class AnswersRepository extends ServiceEntityRepository implements AnswersRepositoryInterface
{
    private ObjectManager $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
        $this->entityManager = $registry->getManager();
    }

    public function findById(int $id): ?Answer
    {
        return $this->find($id);
    }
}