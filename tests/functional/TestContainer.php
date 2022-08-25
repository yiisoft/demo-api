<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class TestContainer implements ContainerInterface
{
    private array $instances = [];

    public function set(string $id, object $instance): void
    {
        $this->instances[$id] = $instance;
    }

    public function get(string $id)
    {
        return $this->instances[$id] ?? throw new class () extends Exception implements NotFoundExceptionInterface {};
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->instances);
    }
}
