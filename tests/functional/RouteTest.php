<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class RouteTest extends FunctionalTestCase
{
    public function testRoute()
    {
        $method = 'GET';
        $url = '/';

        $this->bootstrapApplication('web');
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
        $this->bootstrapApplication('web');
        $container = $this->getContainer();

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertTrue($container->has(LoggerInterface::class));
    }
}
