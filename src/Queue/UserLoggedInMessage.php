<?php

declare(strict_types=1);

namespace App\Queue;

use Yiisoft\Yii\Queue\Message\AbstractMessage;

final class UserLoggedInMessage extends AbstractMessage
{
    public function __construct(private string $userId, private int $time)
    {
    }

    public function getHandlerName(): string
    {
        return LoggingAuthorizationHandler::NAME;
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'time' => $this->time,
        ];
    }
}
