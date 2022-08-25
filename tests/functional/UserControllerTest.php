<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\VersionProvider;
use Psr\Http\Message\ResponseInterface;

class UserControllerTest extends FunctionalTestCase
{
    public function testGet()
    {
        $method = 'GET';
        $url = '/';

        $this->bootstrapApplication('web');

        $container = $this->getTestContainer();
        $container->set(VersionProvider::class, new VersionProvider('3.0.0'));

        $response = $this->doRequest($method, $url);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $stream = $response->getBody();
        $stream->rewind();
        $content = $stream->getContents();

        $this->assertSame(
            '{"status":"success","error_message":"","error_code":null,"data":{"version":"3.0.0","author":"yiisoft"}}',
            $content
        );
    }

    public function testGet2()
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
}
