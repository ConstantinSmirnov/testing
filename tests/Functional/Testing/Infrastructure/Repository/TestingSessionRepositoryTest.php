<?php

namespace Functional\Testing\Infrastructure\Repository;

use App\Users\Domain\Factory\UserFactory;
use App\Tests\Helpers\WebTestHelper;
use App\Testing\Domain\Factory\TestingSessionFactory;
use App\Testing\Infrastructure\Repository\TestingSessionRepository;
use App\Users\Infrastructure\Repository\UserRepository;

class TestingSessionRepositoryTest extends WebTestHelper
{
    private TestingSessionRepository $repository;
    private UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = static::getContainer()->get(TestingSessionRepository::class);
        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    public function test_testing_session_added_repository(): void
    {
        $userName = $this->faker->name();
        $user = (new UserFactory())->create($userName);
        $this->userRepository->add($user);

        $testingSession = (new TestingSessionFactory())->create($user);
        $this->repository->add($testingSession);

        $existingTestingSession = $this->repository->findById($testingSession->getId());
        $this->assertEquals($testingSession->getId(), $existingTestingSession->getId());
    }

}
