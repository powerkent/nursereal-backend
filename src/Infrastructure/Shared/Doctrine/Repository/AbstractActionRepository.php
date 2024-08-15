<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\AbstractAction;
use Nursery\Domain\Shared\Repository\AbstractActionRepositoryInterface;

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
