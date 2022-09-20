<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\VersionProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class UserControllerTest extends TestCase
{
    private ?FunctionalTester $tester;

    protected function setUp(): void
    {
        $this->tester = new FunctionalTester();
    }

    public function testGet()
    {
        $method = 'GET';
        $url = '/';

        $this->tester->bootstrapApplication('web');

        $this->tester->mockService(VersionProvider::class, new VersionProvider('3.0.0'));

        $response = $this->tester->doRequest($method, $url);

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

        $this->tester->bootstrapApplication('web');
        $response = $this->tester->doRequest($method, $url);

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
