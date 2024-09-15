<?php

namespace Functional\Users\Infrastucture\Repository;

use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Users\Domain\Factory\UserFactory;

class UserRepositoryTest extends WebTestCase
{
    private $previousExceptionHandler;
    private UserRepository $repository;
    private Generator $faker;
    private AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->previousExceptionHandler = set_exception_handler(null);

        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->faker = Factory::create();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    protected function tearDown(): void
    {
        set_exception_handler($this->previousExceptionHandler);
        parent::tearDown();
    }

    public function test_user_added_repository(): void
    {
        $name = $this->faker->name();
        $user = (new UserFactory())->create($name);

        $this->repository->add($user);

        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }

    public function test_user_found_successfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
        $user = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE);

        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }
}