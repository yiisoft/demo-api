<?php

declare(strict_types=1);

namespace App\Blog;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use Cycle\ORM\Transaction;
use Yiisoft\Yii\Cycle\Data\Reader\EntityReader;

final class PostRepository extends Select\Repository
{
    public function __construct(Select $select, private ORMInterface $orm)
    {
        parent::__construct($select);
    }

    public function findAll(array $scope = [], array $orderBy = []): EntityReader
    {
        return new EntityReader(
            $this
                ->select()
                ->where($scope)
                ->orderBy($orderBy)
        );
    }

    public function save(Post $user): void
    {
        $transaction = new Transaction($this->orm);
        $transaction->persist($user);
        $transaction->run();
    }
}
