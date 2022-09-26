<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Yii\Testing\FunctionalTestCase;

class RouteTest extends FunctionalTestCase
{
    public function testRoute()
    {
        $method = 'GET';
        $url = '/';

        $this->bootstrapApplication('web',dirname(__DIR__, 2));
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
        $this->bootstrapApplication('web', dirname(__DIR__, 2));
        $container = $this->getContainer();

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertTrue($container->has(LoggerInterface::class));
    }
}
