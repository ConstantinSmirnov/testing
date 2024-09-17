<?php

namespace App\Testing\Infrastructure\Repository;

use App\Testing\Domain\Entity\TestingSession;
use App\Testing\Domain\Entity\UserResponse;
use App\Testing\Domain\Repository\UserResponseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class UserResponseRepository extends ServiceEntityRepository implements UserResponseRepositoryInterface
{
    private ObjectManager $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserResponse::class);
        $this->entityManager = $registry->getManager();
    }

    public function add(UserResponse $userResponse): void
    {
        $this->entityManager->persist($userResponse);
        $this->entityManager->flush();
    }

    public function findBySession(TestingSession $session): ?array
    {
        return $this->findBy(['testingSession' => $session]);
    }
}