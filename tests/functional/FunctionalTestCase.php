<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

abstract class FunctionalTestCase extends TestCase
{
    protected ?FunctionalTester $tester;

    protected function setUp(): void
    {
        $this->tester = new FunctionalTester();
    }

    public function mockService(string $id, mixed $definition): void
    {
        $this->tester->mockService($id, $definition);
    }

    protected function bootstrapApplication(string $applicationEnvironment = 'web'): void
    {
        $this->tester->bootstrapApplication($applicationEnvironment);
    }

    protected function doRequest(string $method, string $url): ResponseInterface
    {
        return $this->tester->doRequest($method, $url);
    }

    protected function getContainer(): ContainerInterface
    {
        return $this->tester->getContainer();
    }
}
