<?php

declare(strict_types=1);

namespace App\Queue;

use Psr\Log\LoggerInterface;
use Yiisoft\Yii\Queue\Message\MessageInterface;

final class LoggingAuthorizationHandler
{
    public const NAME = 'logging-authorization-handler';
    public const CHANNEL = 'logging-authorization-channel';

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(MessageInterface $message): void
    {
        $this->logger->info('User is login', [
            'data' => $message->getData(),
        ]);
    }
}
