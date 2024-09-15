<?php

namespace App\Tests\Helpers;

use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebTestHelper extends WebTestCase
{
    private $previousExceptionHandler;
    public Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->previousExceptionHandler = set_exception_handler(null);
        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        set_exception_handler($this->previousExceptionHandler);
        parent::tearDown();
    }
}