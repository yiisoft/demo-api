<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Psr\Http\Message\ResponseInterface;

class ResponseGrabber
{
    private ?ResponseInterface $response = null;

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    public function setResponse(?ResponseInterface $response): void
    {
        $this->response = $response;
    }
}
