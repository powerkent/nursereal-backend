<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\AbstractAction;
use Nursery\Domain\Nursery\Repository\AbstractActionRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<AbstractAction>
 */
class AbstractActionRepository extends AbstractRepository implements AbstractActionRepositoryInterface
{
    protected static function entityClass(): string
    {
        return AbstractAction::class;
    }
}
