<?php

namespace App\Tests\Resource\Fixture;

use App\Tests\Helpers\FakerHelper;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    use FakerHelper;

    const REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        $name = $this->getFaker()->name();
        $user = (new UserFactory())->create($name);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}