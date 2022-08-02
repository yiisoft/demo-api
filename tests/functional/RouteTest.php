<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class RouteTest extends TestCase
{
    private static ?TestApplicationRunner $application = null;

    public function testRoute()
    {
        self::$application = null;

        $method = 'GET';
        $url = '/';

        $response = $this->doRequest($method, $url);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $stream = $response->getBody();
        $stream->rewind();
        $content = $stream->getContents();

        $this->assertSame(
            '{"status":"success","error_message":"","error_code":null,"data":{"version":"3.0","author":"yiisoft"}}',
            $content
        );
    }

    public function testContainer()
    {
        self::$application = null;
        $container = $this->getContainer();

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertTrue($container->has(LoggerInterface::class));
    }

    private function doRequest(string $method, string $url): ?ResponseInterface
    {
        $this->bootstrapApplication();

        self::$application->withRequest($method, $url);
        self::$application->run();

        return self::$application->responseGrabber->getResponse();
    }

    private function getContainer(): ?ContainerInterface
    {
        $this->bootstrapApplication();
        self::$application->preloadContainer();

        return self::$application->container;
    }

    private function bootstrapApplication(): void
    {
        if (self::$application === null) {
            self::$application = new TestApplicationRunner(new ResponseGrabber(), dirname(__DIR__, 2), false, null);
        }
    }
}
