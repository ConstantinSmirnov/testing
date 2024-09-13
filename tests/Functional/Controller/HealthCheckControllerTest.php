<?php

namespace Functional\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HealthCheckControllerTest extends WebTestCase
{
    private $previousExceptionHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->previousExceptionHandler = set_exception_handler(null);
    }

    protected function tearDown(): void
    {
        set_exception_handler($this->previousExceptionHandler);
        parent::tearDown();
    }

    public function test_request_successfully_result(): void
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, '/health-check');

        $this->assertResponseIsSuccessful();
        $result = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($result['status'], 'ok');
    }
}
