<?php

declare(strict_types=1);

use App\Provider\RepositoryProvider;
use Yiisoft\Arrays\Modifier\ReverseBlockMerge;

return [
    RepositoryProvider::class => RepositoryProvider::class,
    ReverseBlockMerge::class => new ReverseBlockMerge(),
];
