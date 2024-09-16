<?php

namespace App\Testing\Infrastructure\Repository;

use App\Testing\Domain\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use App\Testing\Domain\Repository\QuestionRepositoryInterface;

class QuestionRepository extends ServiceEntityRepository implements QuestionRepositoryInterface
{
    private ObjectManager $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
        $this->entityManager = $registry->getManager();
    }

    public function findAllNotIn(array $ids): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('q')
            ->from(Question::class, 'q')
            ->where($queryBuilder->expr()->notIn('q.id', ':ids'))
            ->setParameter('ids', $ids);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findById(int $id): ?Question
    {
        return $this->find($id);
    }

    public function findAllQuestions(): array
    {
        return $this->findAll();
    }
}