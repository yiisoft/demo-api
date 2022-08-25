<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

abstract class FunctionalTestCase extends TestCase
{
    private static ?TestApplicationRunner $application = null;

    protected function tearDown(): void
    {
        self::$application = null;
    }

    protected function bootstrapApplication(string $applicationEnvironment = 'web'): void
    {
        if (self::$application === null) {
            self::$application = new TestApplicationRunner(
                new ResponseGrabber(),
                dirname(__DIR__, 2),
                false,
                null,
                $applicationEnvironment
            );
        }
    }

    protected function doRequest(string $method, string $url): ResponseInterface
    {
        $this->ensureApplicationLoaded();

        self::$application->withRequest($method, $url);
        self::$application->run();

        return self::$application->responseGrabber->getResponse();
    }

    protected function getContainer(): ContainerInterface
    {
        $this->ensureApplicationLoaded();

        self::$application->preloadContainer();

        return self::$application->container;
    }

    protected function getTestContainer(): TestContainer
    {
        $this->ensureApplicationLoaded();

        return self::$application->getTestContainer();
    }

    private function ensureApplicationLoaded(): void
    {
        if (self::$application === null) {
            throw new RuntimeException(
                'The application was not initialized. Initialize the application before the request: `$this->bootstrapApplication(\'web\')`.'
            );
        }
    }
}
