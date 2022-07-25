<?php

declare(strict_types=1);

namespace App\Queue;

use Psr\Log\LoggerInterface;
use Yiisoft\Yii\Queue\Message\MessageInterface;

final class LoggingAuthorizationHandler
{
    public const NAME = 'logging-authorization-handler';
    public const CHANNEL = 'logging-authorization-channel';

    public function __construct(private LoggerInterface $logger)
    {
    }

    public function handle(MessageInterface $message): void
    {
        $this->logger->info('User is login', [
            'data' => $message->getData(),
        ]);
    }
}
