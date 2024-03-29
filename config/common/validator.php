<?php

declare(strict_types=1);

use Yiisoft\Validator\RuleHandlerContainer;
use Yiisoft\Validator\RuleHandlerResolverInterface;

/** @var array $params */

return [
    RuleHandlerResolverInterface::class => RuleHandlerContainer::class,
];
