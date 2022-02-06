<?php

declare(strict_types=1);

namespace App\Infrastructure\IO\Http\Blog\PutUpdate\Request;

use App\Application\Blog\Entity\Post\PostStatus;
use OpenApi\Annotations as OA;
use Yiisoft\RequestModel\RequestModel;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

/**
 * @OA\Schema(
 *      schema="BlogUpdateRequest",
 *      @OA\Property(example="Title post", property="title", format="string"),
 *      @OA\Property(example="Text post", property="text", format="string"),
 *      @OA\Property(example=1, property="status", format="int"),
 * )
 */
final class Request extends RequestModel implements RulesProviderInterface
{
    public function getId(): int
    {
        return (int)$this->getAttributeValue('router.id');
    }

    public function getTitle(): string
    {
        return (string)$this->getAttributeValue('body.title');
    }

    public function getText(): string
    {
        return (string)$this->getAttributeValue('body.text');
    }

    public function getStatus(): PostStatus
    {
        return PostStatus::from($this->getAttributeValue('body.status'));
    }

    public function getRules(): array
    {
        return [
            'body.title' => [
                Required::rule(),
                HasLength::rule()
                    ->min(5)
                    ->max(255),
            ],
            'body.text' => [
                Required::rule(),
                HasLength::rule()
                    ->min(5)
                    ->max(1000),
            ],
            'body.status' => [
                Required::rule(),
                static function ($value): Result {
                    $result = new Result();
                    if (!PostStatus::isValid($value)) {
                        $result->addError('Incorrect status');
                    }
                    return $result;
                },
            ],
        ];
    }
}