<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RouteTest extends TestCase
{
    public function testRoute()
    {
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

    private function doRequest(string $method, string $url): ?ResponseInterface
    {
        $grabber = new ResponseGrabber();
        $app = new TestApplicationRunner($grabber, dirname(__DIR__, 2), false, null);

        $app->withRequest($method, $url);
        $app->run();

        return $grabber->getResponse();
    }

}
