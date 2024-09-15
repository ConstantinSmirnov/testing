<?php

namespace App\Testing\Infrastructure\Repository;

use App\Testing\Domain\Entity\TestingSession;
use App\Testing\Domain\Repository\TestingSessionRepositoryInterface;
use App\Users\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class TestingSessionRepository extends ServiceEntityRepository implements TestingSessionRepositoryInterface
{
    private ObjectManager $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestingSession::class);
        $this->entityManager = $registry->getManager();
    }

    public function add(TestingSession $testingSession): void
    {
        $this->entityManager->persist($testingSession);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?TestingSession
    {
        return $this->find($id);
    }

    public function findLatestByUserId(User $user): ?TestingSession
    {
        return $this->findOneBy(['isEnd' => false, 'user' => $user]);
    }
}