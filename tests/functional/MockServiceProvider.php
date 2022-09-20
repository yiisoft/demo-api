<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Yiisoft\Di\ServiceProviderInterface;

class MockServiceProvider implements ServiceProviderInterface
{
    private array $definitions = [];
    private array $extensions = [];

    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    public function getExtensions(): array
    {
        return $this->extensions;
    }

    public function addDefinition(string $id, mixed $definition)
    {
        return $this->definitions[$id] = $definition;
    }
}
